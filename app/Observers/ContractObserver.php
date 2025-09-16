<?php

namespace App\Observers;

use App\Manager\CompanyManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ContractObserver
{
    public function creating(Model $model)
    {
        $companyManager = new CompanyManager();
        $contract = $companyManager->getContractDefault();

        if(Auth::user()->company->type != 'admin') {
            $model->setAttribute('contract_id', $contract);
        }
    }
}
