<?php

namespace App\Scope;

use App\Manager\CompanyManager;
use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
	if(Auth::user()->id==248){
	     $builder->whereIn('contract_id', function ($query) {
	         $query->select('id')
	            ->from('companies_contracts')
	            ->whereIn('contractor_id', function ($query) {
	               $query->select('id')
	                  ->from('companies')
	                  ->where('user_id', 248);
	        });

	   });
	}else{

		$CompanyManager = new CompanyManager();
		$company_id = $CompanyManager->getCompanyIdentify();
		$contract_id =  $CompanyManager->getContractDefault();
	         $builder->where('company_id', $company_id);

	        if(Auth::user()->company->type != 'admin') {
	            $builder->where('contract_id', $contract_id);
	        }
	}
    }
}
