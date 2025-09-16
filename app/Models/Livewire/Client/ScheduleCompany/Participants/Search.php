<?php

namespace App\Livewire\Client\ScheduleCompany\Participants;

use Livewire\Component;

class Search extends Component
{
    public $filter = [];

    public function updatedFilterSearch()
    {
        $this->dispatch('filterCardParticipantsClient', filterData:$this->filter['search']);

    }
    public function render()
    {
        return view('livewire.client.schedule-company.participants.search');
    }
}
