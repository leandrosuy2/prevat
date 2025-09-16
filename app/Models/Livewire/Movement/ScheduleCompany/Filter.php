<?php

namespace App\Livewire\Movement\ScheduleCompany;

use App\Repositories\CompanyRepository;
use App\Repositories\SchedulePrevatRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'date_event' => '',
        'company_id' => '',
        'schedule_prevat_id' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableScheduleCompany', filterData: $request);
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

        return view('livewire.movement.schedule-company.filter', ['response' => $response]);
    }
}
