<?php

namespace App\Livewire\Financial\Releases\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReleases');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableParticipantsReleases', filterData: $request);
    }
    public function render()
    {
        return view('livewire.financial.releases.participants.filter');
    }
}
