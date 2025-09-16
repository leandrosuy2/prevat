<?php

namespace App\Livewire\Financial\Releases;

use App\Repositories\CompanyRepository;
use App\Repositories\SchedulePrevatRepository;
use Livewire\Component;
class Filter extends Component
{
    public $filter = [
        'dates' => '',
        'company_id' => '',
        'schedule_prevat_id' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterFinancial');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableScheduleCompanyFinancial', filterData: $request);
    }

    public function getSelectSchedulePrevat()
    {
        $schedulePrevatRepository = new SchedulePrevatRepository();
        return $schedulePrevatRepository->getSelectSchedulePrevat();
    }

    public function getSelectCompanies()
    {
        $companiesRepository = new CompanyRepository();
        return $companiesRepository->getSelectCompany();
    }
    public function render()
    {
        $response = new \stdClass();
        $response->schedulePrevats = $this->getSelectSchedulePrevat();
        $response->companies = $this->getSelectCompanies();

        return view('livewire.financial.releases.filter', ['response' => $response]);
    }
}
