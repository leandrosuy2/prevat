<?php

namespace App\Http\Middleware;

use App\Manager\CompanyManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDefaultContract
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $companyManager = new CompanyManager();
        $contractDefault = $companyManager->getContractDefaultActive();

            if(Auth::user()->company->type == 'client' && Auth::user()->contracts->count() == 0) {
                return redirect()->route('client.alert.no-contracts');
            } elseif (Auth::user()->company->type == 'client' && Auth::user()->contracts->count() > 0 && !$contractDefault) {
                return redirect()->route('client.alert.change-contract');
            }

        return $next($request);
    }
}
