<?php

namespace App\Http\Controllers;

use App\Models\ClassTimetable;
use App\Models\ExamTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $classTimetables = ClassTimetable::with('schoolClass')->latest()->get();
        $examTimetables = ExamTimetable::latest()->get();

        return view('timetables.index', compact('classTimetables', 'examTimetables'));
    }

    /** Teacher uploads a class timetable for one of their own classes. */
    public function storeClassTimetable(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $validated = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'title' => ['required', 'string', 'max:150'],
            'file' => ['required', 'file', 'max:5120'],
        ]);

        abort_unless(
            $teacher->classes()->where('school_classes.id', $validated['school_class_id'])->exists(),
            403,
            'You may only upload a timetable for your own class.'
        );

        $path = $request->file('file')->store('timetables', 'public');

        ClassTimetable::create([
            'school_class_id' => $validated['school_class_id'],
            'teacher_id' => $teacher->id,
            'title' => $validated['title'],
            'file_path' => $path,
        ]);

        return back()->with('status', 'Class timetable uploaded.');
    }

    /** School Admin uploads an exam timetable, school-wide or per level. */
    public function storeExamTimetable(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'level' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:5120'],
        ]);

        $path = $request->file('file')->store('timetables', 'public');

        ExamTimetable::create([
            'school_admin_id' => Auth::user()->schoolAdmin->id,
            'title' => $validated['title'],
            'level' => $validated['level'] ?? null,
            'file_path' => $path,
        ]);

        return back()->with('status', 'Exam timetable uploaded.');
    }
}
