<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('schoolAdmin.user')->latest()->paginate(15);

        return view('notices.index', compact('notices'));
    }

    /** School Admin only. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string'],
        ]);

        Notice::create([
            'school_admin_id' => Auth::user()->schoolAdmin->id,
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return back()->with('status', 'Notice published to the whole school.');
    }
}
