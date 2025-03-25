<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * @param mixed $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next,mixed $role): mixed
    {
        if (! Auth::check() || ! $request->user()->hasRole($role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
