<?php

namespace App\Livewire\Registration\Contractors;

use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'status' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableContractors', filterData: $request);
    }
    public function render()
    {
        return view('livewire.registration.contractors.filter');
    }
}
