<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SkillHarborActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $skillharbor = true;
        // Check if the user is authenticated and has incomplete details
        if (Auth::check() && $skillharbor = false) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
