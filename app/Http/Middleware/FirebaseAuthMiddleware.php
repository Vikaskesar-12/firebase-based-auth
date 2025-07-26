<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FirebaseAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if UID is stored in session
        if (!Session::has('uid')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
