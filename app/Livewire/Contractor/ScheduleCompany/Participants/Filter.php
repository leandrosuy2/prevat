<?php

namespace App\Livewire\Contractor\ScheduleCompany\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableParticipantsScheduleCompanyContractor', filterData: $request);
    }

    public function render()
    {
        return view('livewire.contractor.schedule-company.participants.filter');
    }
}
