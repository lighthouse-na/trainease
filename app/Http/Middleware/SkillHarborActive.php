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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $skillharbor = false;
        // Check if the user is authenticated and has incomplete details
        if (Auth::check() && $skillharbor = true) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
