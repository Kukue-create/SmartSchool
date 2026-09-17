<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /** Public online application form - prospective students, no login required. */
    public function create()
    {
        return view('enrollment.create', ['levels' => config('school.levels')]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_full_name' => ['required', 'string', 'max:150'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'level_applied_for' => ['required', 'string', 'in:'.implode(',', config('school.levels'))],
            'results' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ], [
            'results.required' => 'Please upload your results.',
            'results.mimes' => 'Results must be a PDF, JPG or PNG file.',
            'results.max' => 'The results file may not be larger than 10MB.',
        ]);

        $resultsPath = $request->file('results')->store('enrollment-results', 'public');

        Enrollment::create([
            'applicant_full_name' => $validated['applicant_full_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'level_applied_for' => $validated['level_applied_for'],
            'results_file_path' => $resultsPath,
        ]);

        return back()->with('status', 'Application submitted! The school will contact you regarding next steps.');
    }

    /** School Admin: review applications. */
    public function index()
    {
        $enrollments = Enrollment::latest()->paginate(20);

        return view('enrollment.index', compact('enrollments'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,under_review,approved,rejected'],
            'notes' => ['nullable', 'string'],
        ]);

        $enrollment->update([
            ...$validated,
            'reviewed_by_school_admin_id' => Auth::user()->schoolAdmin->id,
        ]);

        return back()->with('status', 'Application updated.');
    }
}
