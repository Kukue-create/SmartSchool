<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Teacher: mark attendance, but ONLY if this teacher is a class
     * teacher, and only for the class(es) they are the class teacher of -
     * never for classes they merely teach a subject in.
     */
    public function manage()
    {
        $teacher = Auth::user()->teacher()->with('classTeacherOf.students.user')->first();

        abort_unless($teacher && $teacher->is_class_teacher, 403, 'Only class teachers may mark attendance.');

        return view('attendance.manage', ['teacher' => $teacher]);
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        abort_unless($teacher && $teacher->is_class_teacher, 403, 'Only class teachers may mark attendance.');

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:present,absent,late'],
        ]);

        $studentClassId = Student::findOrFail($validated['student_id'])->school_class_id;

        abort_unless(
            $teacher->canMarkAttendanceForClass($studentClassId),
            403,
            'You may only mark attendance for the class(es) you are the class teacher of.'
        );

        Attendance::updateOrCreate(
            ['student_id' => $validated['student_id'], 'date' => $validated['date']],
            ['teacher_id' => $teacher->id, 'status' => $validated['status']]
        );

        return back()->with('status', 'Attendance recorded.');
    }

    /** Student: view own attendance record. */
    public function mine()
    {
        $student = Auth::user()->student;
        $records = $student->attendance()->latest('date')->get();

        return view('attendance.mine', compact('records'));
    }
}
