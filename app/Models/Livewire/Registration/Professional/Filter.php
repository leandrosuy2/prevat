<?php

namespace App\Livewire\Registration\Professional;

use Livewire\Component;

class Filter extends Component

{    public $filter = [
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
        $this->dispatch('filterTableProfessionals', filterData: $request);
    }

    public function render()
    {
        return view('livewire.registration.professional.filter');
    }
}
