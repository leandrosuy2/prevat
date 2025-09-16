<?php

namespace App\Http\Middleware;

use App\Manager\CompanyManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $manager = new CompanyManager();
        $companyClient = $manager->isScopeClient();

        if(!$companyClient){
            abort(404);
        }

        return $next($request);
    }
}
