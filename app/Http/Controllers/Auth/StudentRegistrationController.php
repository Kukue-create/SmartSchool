<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Services\EmailGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationController extends Controller
{
    /** Pull step-1 data out of the session or bounce back to the start. */
    protected function step1(Request $request): array
    {
        $data = $request->session()->get('registration.step1');

        abort_unless($data && $data['role'] === 'student', 403, 'Please start registration again.');

        return $data;
    }

    public function create(Request $request)
    {
        $step1 = $this->step1($request);

        $previewEmail = EmailGenerator::generate($step1['full_name'], 'student');

        return view('auth.register-student', [
            'fullName' => $step1['full_name'],
            'previewEmail' => $previewEmail,
            'levels' => config('school.levels'),
            'classesByLevel' => config('school.classes_by_level'),
            'subjects' => config('school.subjects'),
            'genders' => config('school.genders'),
        ]);
    }

    public function store(Request $request)
    {
        $step1 = $this->step1($request);

        $validated = $request->validate([
            'level' => ['required', 'string', 'in:'.implode(',', config('school.levels'))],
            'school_class' => ['required', 'string'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*' => ['string', 'in:'.implode(',', config('school.subjects'))],
            'gender' => ['required', 'string', 'in:'.implode(',', config('school.genders'))],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'nationality' => ['required', 'string', 'max:100'],
        ]);

        $schoolClass = SchoolClass::firstOrCreate([
            'level' => $validated['level'],
            'name' => $validated['school_class'],
        ]);

        $email = EmailGenerator::generate($step1['full_name'], 'student');

        DB::transaction(function () use ($step1, $validated, $schoolClass, $email) {
            $user = User::create([
                'full_name' => $step1['full_name'],
                'username' => $step1['username'],
                'email' => $email,
                'password' => Hash::make($step1['password']),
                'role' => 'student',
                'gender' => $validated['gender'],
                'nationality' => $validated['nationality'],
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'school_class_id' => $schoolClass->id,
                'level' => $validated['level'],
                'date_of_birth' => $validated['date_of_birth'],
            ]);

            $subjectIds = Subject::whereIn('name', $validated['subjects'])->pluck('id');
            $student->subjects()->sync($subjectIds);
        });

        $request->session()->forget('registration.step1');

        return redirect()->route('login')
            ->with('status', "Registration complete! Your login email is {$email}. Please log in below.");
    }
}
