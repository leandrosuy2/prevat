<?php

namespace App\Livewire\Movement\ParticipantTraining\Private\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [];

    public function updatedFilterSearch()
    {
        $this->dispatch('filterCardParticipantsTraining', filterData:$this->filter['search']);

    }

    public function render()
    {
        return view('livewire.movement.participant-training.private.participants.filter');
    }
}
