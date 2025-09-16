<?php

namespace App\Livewire\Financial\ServiceOrder\Releases;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'start_date' => '',
        'end_date' => '',
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterReleases');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableReleases', filterData: $request);
    }

    public function render()
    {
        return view('livewire.financial.service-order.releases.filter');
    }
}
