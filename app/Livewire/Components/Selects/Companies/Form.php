<?php

namespace App\Livewire\Components\Selects\Companies;

use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $company_id;

    public function updatedCompanyID()
    {
        $this->dispatch('filterScheduleTrainingByCompany', company_id:$this->company_id);
    }
    
    public function getSelectCompanies()
    {
        $companyRepository = new CompanyRepository();
        return $companyRepository->getSelectCompany();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();

        return view('livewire.components.selects.companies.form', ['response' => $response]);
    }
}
