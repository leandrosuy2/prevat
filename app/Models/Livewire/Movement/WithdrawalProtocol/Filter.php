<?php

namespace App\Livewire\Movement\WithdrawalProtocol;

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
        $this->dispatch('filterTableWithDrawalProtocol', filterData: $request);
    }

    public function render()
    {
        return view('livewire.movement.withdrawal-protocol.filter');
    }
}
