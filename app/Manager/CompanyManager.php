<?php

namespace App\Manager;

use App\Models\CompaniesContracts;
use Illuminate\Support\Facades\Auth;

class CompanyManager
{
    public function getCompanyIdentify()
    {
        return auth()->user()->company->id;
    }

    public function getContractDefault()
    {
        return auth()->user()->contract_id;
    }

    public function getContractDefaultActive()
    {
        return CompaniesContracts::query()->where('id', auth()->user()->contract_id)->where('status', 'Ativo')->first();
    }

    public function isScopeAdmin()
    {
        $scope = auth()->user()->company->type;
        $scopeAdmin = 'admin';

        return $scope == $scopeAdmin;
    }

    public function isScopeClient()
    {
        $scope = auth()->user()->company->type;
        $scopeClient = 'client';

        return $scope == $scopeClient;
    }

    public function isScopeContractor()
    {
        $scope = auth()->user()->company->type;
        $scopeContractor = 'contractor';

        return $scope == $scopeContractor;
    }

}
