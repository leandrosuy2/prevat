<?php

namespace App\Http\Middleware;

use App\Manager\CompanyManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RouteContractor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Permite acesso especial para o usuário específico
        if (Auth::user()->email === 'SASHA.Assuncao@hydro.com') {
            return $next($request);
        }

        $manager = new CompanyManager();
        $manager->isScopeContractor();

        return $next($request);
    }
}
