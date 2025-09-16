<?php

namespace App\Livewire\Movement\ScheduleCompany\Participants;

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
        $this->dispatch('filterTableParticipantsScheduleCompany', filterData: $request);
    }

    public function render()
    {
        return view('livewire.movement.schedule-company.participants.filter');
    }
}
