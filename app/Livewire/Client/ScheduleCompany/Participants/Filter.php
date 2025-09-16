<?php

namespace App\Livewire\Client\ScheduleCompany\Participants;

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
        $this->dispatch('filterTableParticipantsScheduleCompanyClient', filterData: $request);
    }
    public function render()
    {
        return view('livewire.client.schedule-company.participants.filter');
    }
}
