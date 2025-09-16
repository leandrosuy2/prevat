<?php

namespace App\Livewire\Financial\PaymentMethod;

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
        $this->dispatch('filterTablePaymentMethod', filterData: $request);
    }

    public function render()
    {
        return view('livewire.financial.payment-method.filter');
    }
}
