<?php

namespace App\Livewire\WorkSafety\Inspection;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => null,
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterInspections');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableInspections', filterData: $request);
    }

    public function render()
    {
        return view('livewire.work-safety.inspection.filter');
    }
}
