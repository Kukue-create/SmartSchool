<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts a route to one or more account roles (student, teacher, school_admin).
 * The system administrator (owner) uses a separate guard/middleware
 * (EnsureSystemAdmin) since it is not a self-registered account.
 *
 * Usage: ->middleware('role:teacher') or ->middleware('role:teacher,school_admin')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'You are not authorised to view this page.');
        }

        return $next($request);
    }
}
