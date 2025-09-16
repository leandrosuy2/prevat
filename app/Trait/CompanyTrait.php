<?php

namespace App\Trait;

use App\Observers\CompanyObserver;
use App\Observers\ContractObserver;
use App\Observers\Tenant\TenantObserver;
use App\Scope\CompanyScope;
use App\Scope\ContractScope;
use App\Scopes\Tenant\TenantScope;
use Illuminate\Support\Facades\Auth;

trait CompanyTrait
{
    protected static function boot ()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        if(Auth::user() && Auth::user()->company->type == 'client') {
            static::observe(new CompanyObserver);
        }
    }
}
