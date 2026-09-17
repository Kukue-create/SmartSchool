<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuditRequests
{
    protected array $auditedMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), $this->auditedMethods, true) && $response->getStatusCode() < 400) {
            try {
                AuditLog::create([
                    'user_id' => Auth::id(),
                    'actor_label' => Auth::check() ? Auth::user()->email : ($request->session()->get('is_system_admin') ? 'system_admin' : 'guest'),
                    'action' => $request->method().' '.$request->path(),
                    'ip_address' => $request->ip(),
                ]);
            } catch (\Throwable $e) {
                // Never let audit logging break the request/response cycle.
            }
        }

        return $response;
    }
}
