<?php

namespace App\Livewire\Financial\ServiceOrder\View\Participants;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterParticipantsView');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableParticipantsView', filterData: $request);
    }

    public function render()
    {
        return view('livewire.financial.service-order.view.participants.filter');
    }
}
