<?php

namespace App\Livewire\System\Users;

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
        $this->dispatch('filterTableUsers', filterData: $request);
    }
    public function render()
    {
        return view('livewire.system.users.filter');
    }
}
