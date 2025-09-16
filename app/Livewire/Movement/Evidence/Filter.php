<?php

namespace App\Livewire\Movement\Evidence;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'date_start' => '',
        'date_end' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }
    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableEvidences', filterData: $request);
    }
    public function render()
    {
        return view('livewire.movement.evidence.filter');
    }
}
