<?php

namespace App\Livewire\Movement\SchedulePrevat\Participants;

use App\Models\ScheduleCompany;
use App\Repositories\CompanyRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'company_id' => null
    ];
    public $companies = [];

    public function mount($id = null)
    {
        $scheduleCompaniesDB = ScheduleCompany::query()->where('schedule_prevat_id', $id)->withoutGlobalScopes()->pluck('company_id');
        $this->companies = $scheduleCompaniesDB;
    }
    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterParticipantsSchedulePrevat');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableParticipantsSchedulePrevat', filterData: $request);
    }

    public function getSelectCompanies()
    {
        $companiesRepository = new CompanyRepository();
        return $companiesRepository->getSelectCompany($this->companies);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();

        return view('livewire.movement.schedule-prevat.participants.filter', ['response' => $response]);
    }
}
