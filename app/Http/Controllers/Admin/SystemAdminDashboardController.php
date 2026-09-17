<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class SystemAdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.system-admin-dashboard', [
            'totalUsers' => User::count(),
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'pendingPayments' => FeePayment::where('status', 'pending')->count(),
            'pendingEnrollments' => Enrollment::where('status', 'submitted')->count(),
        ]);
    }
}
