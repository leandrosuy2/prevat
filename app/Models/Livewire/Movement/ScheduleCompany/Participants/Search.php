<?php

namespace App\Livewire\Movement\ScheduleCompany\Participants;

use Livewire\Component;

class Search extends Component
{
    public $filter = [];

    public function updatedFilterSearch()
    {
        $this->dispatch('filterCardParticipants', filterData:$this->filter['search']);

    }

    public function render()
    {
        return view('livewire.movement.schedule-company.participants.search');
    }
}
