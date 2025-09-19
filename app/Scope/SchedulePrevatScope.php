<?php

namespace App\Scope;

use App\Manager\CompanyManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SchedulePrevatScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(Auth::user()->id == 248){
            // Lógica especial para usuário 248 - não aplica filtro
            return;
        } else {
            $CompanyManager = new CompanyManager();
            $company_id = $CompanyManager->getCompanyIdentify();
            
            // Para SchedulePrevat, só filtramos por company_id
            $builder->where('company_id', $company_id);
        }
    }
}
