<?php

namespace App\Livewire\Movement\Historic;

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
        $this->dispatch('filterTableHistoric', filterData: $request);
    }
    public function render()
    {
        return view('livewire.movement.historic.filter');
    }
}
