<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Step 1 of registration, shared by every role: full name, username,
 * password + confirmation. There is no visible role picker - the role is
 * fixed by which URL was used to get here (/students, /students/teachers,
 * /students/admin - see routes/web.php), via a route default. Step 1 data
 * is held in the session until the role-specific step 2 form (see
 * StudentRegistrationController etc.) is completed and the account is
 * actually created.
 */
class RegistrationController extends Controller
{
    public function create(Request $request)
    {
        $role = $request->route('role', 'student');

        return view('auth.register-step1', ['role' => $role]);
    }

    public function store(Request $request)
    {
        $role = $request->route('role', 'student');

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:150'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Stash step 1 answers in the session; nothing is written to the
        // database until the role-specific registration step is submitted.
        $request->session()->put('registration.step1', [
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'password' => $validated['password'],
            'role' => $role,
        ]);

        return match ($role) {
            'student' => redirect()->route('register.student'),
            'teacher' => redirect()->route('register.teacher'),
            'school_admin' => redirect()->route('register.school-admin'),
        };
    }
}
