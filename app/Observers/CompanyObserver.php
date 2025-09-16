<?php

namespace App\Observers;

use App\Manager\CompanyManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\select;

class CompanyObserver
{
    public function creating(Model $model)
    {
        $companyManager = new CompanyManager();
        $company = $companyManager->getCompanyIdentify();
        $contract = $companyManager->getContractDefault();

        if(Auth::user()->company->type != 'admin') {
            $model->setAttribute('company_id', $company);
            $model->setAttribute('contract_id', $contract);
        }
    }
}
