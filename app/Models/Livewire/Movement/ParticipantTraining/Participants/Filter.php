<?php

namespace App\Livewire\Movement\ParticipantTraining\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $search;

    public function updatedSearch()
    {
        $this->dispatch('filterParticipantUOR', filter:$this->search);
    }

    public function render()
    {
        return view('livewire.movement.participant-training.participants.filter');
    }
}
