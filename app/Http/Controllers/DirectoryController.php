<?php

namespace App\Http\Controllers;

use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\Teacher;

/**
 * Read-only "everyone's information" view for the School Admin role.
 * "The school Admin can see everyone's information but cannot edit."
 */
class DirectoryController extends Controller
{
    public function students()
    {
        $students = Student::with(['user', 'schoolClass', 'subjects'])->get();

        return view('admin.directory-students', compact('students'));
    }

    public function teachers()
    {
        $teachers = Teacher::with(['user', 'classes', 'subjects'])->get();

        return view('admin.directory-teachers', compact('teachers'));
    }

    public function schoolAdmins()
    {
        $schoolAdmins = SchoolAdmin::with('user')->get();

        return view('admin.directory-school-admins', compact('schoolAdmins'));
    }
}
