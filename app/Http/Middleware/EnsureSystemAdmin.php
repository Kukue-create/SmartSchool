<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSystemAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('is_system_admin')) {
            return redirect()->route('system-admin.login');
        }

        return $next($request);
    }
}
