<?php

namespace App\Livewire\Financial\ServiceOrder\View;

use Livewire\Component;

class Index extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.financial.service-order.view.index');
    }
}
