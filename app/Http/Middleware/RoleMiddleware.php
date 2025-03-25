<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Contracts\Role;

class RoleMiddleware
{
    /**
     * @param  Role|string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, Role|string $role): mixed
    {
        if (! Auth::check() || ! $request->user()?->hasRole($role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
