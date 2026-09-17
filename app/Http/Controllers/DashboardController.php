<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notices = Notice::latest()->take(5)->get();

        return match ($user->role) {
            'student' => view('dashboards.student', [
                'student' => $user->student()->with(['schoolClass', 'subjects'])->first(),
                'notices' => $notices,
            ]),
            'teacher' => view('dashboards.teacher', [
                'teacher' => $user->teacher()->with(['classes', 'subjects'])->first(),
                'notices' => $notices,
            ]),
            'school_admin' => view('dashboards.school-admin', [
                'notices' => $notices,
            ]),
        };
    }
}
