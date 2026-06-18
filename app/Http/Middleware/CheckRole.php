<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /** Handle an incoming request. Accepts roles as comma-separated string in route middleware. */
    public function handle(Request $request, Closure $next, $roles = '')
    {
        if (! $request->user()) {
            abort(403);
        }
        $allowed = array_map('trim', explode(',', $roles));
        $role = $request->user()->role ?? null;
        // Allow if explicit role matches
        if ($role && in_array($role, $allowed)) {
            return $next($request);
        }

        // Special case: if 'Guru' is allowed and the user has a related guru model, allow
        if (in_array('Guru', $allowed) && method_exists($request->user(), 'guru') && $request->user()->guru) {
            return $next($request);
        }

        abort(403);
        return $next($request);
    }
}
