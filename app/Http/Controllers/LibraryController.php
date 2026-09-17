<?php

namespace App\Http\Controllers;

use App\Models\BookBorrowing;
use App\Models\DigitalResource;
use App\Models\LibraryBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $books = LibraryBook::latest()->get();
        $resources = DigitalResource::with(['subject', 'teacher.user'])->latest()->get();

        return view('library.index', compact('books', 'resources'));
    }

    /** School Admin: catalogue management. */
    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'author' => ['nullable', 'string', 'max:150'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'total_copies' => ['required', 'integer', 'min:1'],
        ]);

        LibraryBook::create([
            ...$validated,
            'available_copies' => $validated['total_copies'],
        ]);

        return back()->with('status', 'Book added to the library catalogue.');
    }

    /** Student: borrow a book if a copy is available. */
    public function borrow(Request $request, LibraryBook $book)
    {
        abort_if($book->available_copies < 1, 422, 'No copies currently available.');

        BookBorrowing::create([
            'library_book_id' => $book->id,
            'student_id' => Auth::user()->student->id,
            'borrowed_on' => now(),
            'due_on' => now()->addDays(14),
        ]);

        $book->decrement('available_copies');

        return back()->with('status', 'Book borrowed. Please return within 14 days.');
    }

    /** Teacher: upload a past paper / question paper / notes for a subject they teach. */
    public function storeResource(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'type' => ['required', 'in:past_paper,question_paper,revision_notes,other'],
            'title' => ['required', 'string', 'max:200'],
            'level' => ['nullable', 'string'],
            'exam_year' => ['nullable', 'string', 'max:9'],
            'file' => ['required', 'file', 'max:10240'],
        ]);

        abort_unless(
            $teacher->subjects()->where('subjects.id', $validated['subject_id'])->exists(),
            403,
            'You may only upload resources for subjects you teach.'
        );

        $path = $request->file('file')->store('resources', 'public');

        DigitalResource::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $validated['subject_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'level' => $validated['level'] ?? null,
            'exam_year' => $validated['exam_year'] ?? null,
            'file_path' => $path,
        ]);

        return back()->with('status', 'Resource uploaded for students.');
    }
}
