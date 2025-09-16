<?php

namespace App\Scope;

use App\Manager\CompanyManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContractScope
{
    public function apply(Builder $builder, Model $model)
    {
        $CompanyManager = new CompanyManager();
        $contract = $CompanyManager->getCompanyIdentify();

        $builder->where('contract_id', $contract);
    }
}
