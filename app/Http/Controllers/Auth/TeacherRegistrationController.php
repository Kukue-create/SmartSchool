<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Services\EmailGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TeacherRegistrationController extends Controller
{
    protected function step1(Request $request): array
    {
        $data = $request->session()->get('registration.step1');

        abort_unless($data && $data['role'] === 'teacher', 403, 'Please start registration again.');

        return $data;
    }

    /** Turn a "Level :: Name" encoded string into a SchoolClass id, creating the class if needed. */
    protected function resolveClassId(string $encoded): int
    {
        [$level, $name] = array_map('trim', explode('::', $encoded, 2));

        return SchoolClass::firstOrCreate(['level' => $level, 'name' => $name])->id;
    }

    public function create(Request $request)
    {
        $step1 = $this->step1($request);

        $previewEmail = EmailGenerator::generate($step1['full_name'], 'teacher');

        // Flatten every class from every level into one selectable list.
        $allClasses = collect(config('school.classes_by_level'))->flatMap(function ($classes, $level) {
            return collect($classes)->map(fn ($c) => "{$level} :: {$c}");
        })->values();

        return view('auth.register-teacher', [
            'fullName' => $step1['full_name'],
            'previewEmail' => $previewEmail,
            'allClasses' => $allClasses,
            'subjects' => config('school.subjects'),
            'genders' => config('school.genders'),
            'maxClasses' => config('school.max_classes_per_teacher'),
            'maxClassTeacherClasses' => config('school.max_class_teacher_classes'),
        ]);
    }

    public function store(Request $request)
    {
        $step1 = $this->step1($request);
        $max = config('school.max_classes_per_teacher');
        $maxClassTeacher = config('school.max_class_teacher_classes');

        $validated = $request->validate([
            'classes' => ['required', 'array', 'min:1', "max:{$max}"],
            'classes.*' => ['string'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*' => ['string', 'in:'.implode(',', config('school.subjects'))],
            'gender' => ['required', 'string', 'in:'.implode(',', config('school.genders'))],
            'nationality' => ['required', 'string', 'max:100'],
            'is_class_teacher' => ['sometimes', 'boolean'],
            'class_teacher_classes' => ['required_if:is_class_teacher,1', 'array', "max:{$maxClassTeacher}"],
            'class_teacher_classes.*' => ['string'],
        ], [
            'classes.max' => "A teacher may be assigned to at most {$max} classes.",
            'class_teacher_classes.max' => "A class teacher may be the class teacher of at most {$maxClassTeacher} classes.",
            'class_teacher_classes.required_if' => 'Please choose which class(es) you are the class teacher of.',
        ]);

        $isClassTeacher = $request->boolean('is_class_teacher');

        // Resolve the chosen class-teacher classes up front, and reject the
        // registration (with a friendly message) if any of them already
        // has a class teacher - each class may have only one.
        $classTeacherClassIds = collect();
        if ($isClassTeacher) {
            $classTeacherClassIds = collect($validated['class_teacher_classes'])->map(fn ($encoded) => $this->resolveClassId($encoded));

            $taken = SchoolClass::whereIn('id', $classTeacherClassIds)
                ->whereHas('classTeacher')
                ->with('classTeacher.user')
                ->get();

            if ($taken->isNotEmpty()) {
                $names = $taken->map(fn ($c) => "{$c->level} {$c->name} (already assigned to {$c->classTeacher->user->full_name})")->implode(', ');

                throw ValidationException::withMessages([
                    'class_teacher_classes' => "These classes already have a class teacher: {$names}.",
                ]);
            }
        }

        $email = EmailGenerator::generate($step1['full_name'], 'teacher');

        DB::transaction(function () use ($step1, $validated, $email, $isClassTeacher, $classTeacherClassIds) {
            $user = User::create([
                'full_name' => $step1['full_name'],
                'username' => $step1['username'],
                'email' => $email,
                'password' => Hash::make($step1['password']),
                'role' => 'teacher',
                'gender' => $validated['gender'],
                'nationality' => $validated['nationality'],
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'is_class_teacher' => $isClassTeacher,
            ]);

            $classIds = collect($validated['classes'])->map(fn ($encoded) => $this->resolveClassId($encoded));
            $teacher->classes()->sync($classIds);

            $subjectIds = Subject::whereIn('name', $validated['subjects'])->pluck('id');
            $teacher->subjects()->sync($subjectIds);

            if ($isClassTeacher) {
                $teacher->classTeacherOf()->sync($classTeacherClassIds);
            }
        });

        $request->session()->forget('registration.step1');

        return redirect()->route('login')
            ->with('status', "Registration complete! Your login email is {$email}. Please log in below.");
    }
}
