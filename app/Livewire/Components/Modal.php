<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{

    public $blade;
    public $params;
    public $show = 'hide';

    #[On('openModal')]
    public function openModal($blade = null, $params = null)
    {
        $this->blade = $blade;
        $this->params = $params;
        $this->show = 'show';

        $this->dispatch('showModal', params:$this->params, show:$this->show);
    }

    #[On('closeModal')]
    public function closeModal($blade = null, $params = null)
    {
        $this->blade = '';
        $this->params = '';
        $this->show = 'hide';
        $this->dispatch('showSlide', params:$this->params, show:$this->show);
    }
    public function render()
    {
        return view('livewire.components.modal');
    }
}
