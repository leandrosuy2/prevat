<?php

namespace App\Trait;

use App\Scope\SchedulePrevatScope;
use Illuminate\Support\Facades\Auth;

trait SchedulePrevatTrait
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SchedulePrevatScope);
    }
}
