<?php

namespace App\Livewire\Reports\Trainings;

use App\Repositories\CompanyRepository;
use App\Repositories\Reports\CompaniesReport;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => null,
        'company_id' => '',
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReportTrainings');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableReportTrainings', filterData: $request);
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

        return view('livewire.reports.trainings.filter', ['response' => $response]);
    }
}
