<?php

namespace App\Trait;

use App\Observers\ContractObserver;
use App\Scope\ContractScope;
use Illuminate\Support\Facades\Auth;

trait ContractTrait
{
    protected static function boot ()
    {
        parent::boot();

        static::addGlobalScope(new ContractScope());

        if(Auth::user()->company->type == 'client') {
            static::observe(new ContractObserver());
        }
    }
}
