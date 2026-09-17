<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResultController extends Controller
{
    /**
     * Student view: their own results only, once published.
     */
    public function mine()
    {
        $student = Auth::user()->student;

        $results = $student->results()->with('subject')->where('published', true)
            ->orderBy('term')->get();

        return view('results.mine', ['results' => $results]);
    }

    /**
     * Teacher view: a form to upload a mark, restricted to the teacher's own
     * classes and subjects, and a list of marks they have already entered.
     */
    public function manage()
    {
        $teacher = Auth::user()->teacher()->with(['classes.students.user', 'subjects'])->first();

        $gradableStudents = collect();
        foreach ($teacher->classes as $class) {
            foreach ($class->students as $student) {
                foreach ($teacher->subjects as $subject) {
                    if ($teacher->canGradeStudentInSubject($student, $subject)) {
                        $gradableStudents->push(['student' => $student, 'subject' => $subject]);
                    }
                }
            }
        }

        $myResults = Result::where('teacher_id', $teacher->id)->with(['student.user', 'subject'])->latest()->get();

        return view('results.manage', [
            'gradableStudents' => $gradableStudents,
            'myResults' => $myResults,
        ]);
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'term' => ['required', 'string', 'max:50'],
            'mark' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:1'],
            'published' => ['sometimes', 'boolean'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $subject = Subject::findOrFail($validated['subject_id']);

        // Enforce: a teacher may only grade students in their own class AND
        // in a subject they teach that the student is also registered for.
        if (! $teacher->canGradeStudentInSubject($student, $subject)) {
            throw ValidationException::withMessages([
                'student_id' => 'You may only upload marks for students in your own class who take a subject you teach.',
            ]);
        }

        $percentage = round(($validated['mark'] / $validated['total']) * 100, 2);

        Result::updateOrCreate(
            ['student_id' => $student->id, 'subject_id' => $subject->id, 'term' => $validated['term']],
            [
                'teacher_id' => $teacher->id,
                'mark' => $validated['mark'],
                'total' => $validated['total'],
                'percentage' => $percentage,
                'grade' => Result::gradeFor($percentage),
                'published' => $request->boolean('published'),
            ]
        );

        return back()->with('status', 'Mark saved.');
    }

    /**
     * School Admin / System Admin: read-only list of all results
     * (system admin also gets edit/delete via Admin\ResultAdminController).
     */
    public function all()
    {
        $results = Result::with(['student.user', 'subject', 'teacher.user'])->latest()->paginate(50);

        return view('results.all', ['results' => $results]);
    }
}
