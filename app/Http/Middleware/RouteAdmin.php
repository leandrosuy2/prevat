<?php

namespace App\Http\Middleware;

use App\Manager\CompanyManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Libera para o email específico
        if (\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->email === 'SASHA.Assuncao@hydro.com') {
            return $next($request);
        }

        $manager = new CompanyManager();
        $companyAdmin = $manager->isScopeAdmin();

        return $next($request);
    }
}
