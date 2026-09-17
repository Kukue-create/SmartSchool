<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

/**
 * The single "owner" login for the System Administrator, per the brief:
 * "Only the owners of the system should just login straight with System
 * admin password and can view and edit anything in the system."
 * This is intentionally NOT a normal user row - it is one shared secret
 * (SYSTEM_ADMIN_PASSWORD in .env) guarding a session flag.
 */
class SystemAdminAuthController extends Controller
{
    public function create()
    {
        return view('auth.system-admin-login');
    }

    public function store(Request $request)
    {
        $request->validate(['system_admin_password' => ['required', 'string']]);

        $throttleKey = 'system-admin|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'system_admin_password' => 'Too many attempts. Please try again shortly.',
            ]);
        }

        $configured = (string) config('school.system_admin_password');
        $supplied = (string) $request->input('system_admin_password');

        if ($configured === '' || ! hash_equals($configured, $supplied)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'system_admin_password' => 'Incorrect system administrator password.',
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        $request->session()->put('is_system_admin', true);

        return redirect()->route('system-admin.dashboard');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('is_system_admin');
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
