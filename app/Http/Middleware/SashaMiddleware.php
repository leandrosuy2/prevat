<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SashaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->email === 'SASHA.Assuncao@hydro.com') {
            return $next($request);
        }
        abort(404);
    }
} 