<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = $guards[0] ?? null;
        
        if (Auth::guard($guard)->guest()) {
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login');
            } elseif ($request->is('staff/*')) {
                return redirect()->route('staff.login');
            }
            
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
