<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class SlideRight extends Component
{
    public $blade;
    public $params;
    public $show = 'hide';
    #[On('openSlide')]
    public function openSlide($blade = null, $params = null)
    {
//        dd($blade, $params);
        $this->blade = $blade;
        $this->params = $params;
        $this->show = 'show';

        $this->dispatch('showSlide', params:$this->params, show:$this->show);
    }

    #[On('closeSlide')]
    public function closeSlide($blade = null, $params = null)
    {
        $this->blade = '';
        $this->params = '';
        $this->show = 'hide';
        $this->dispatch('showSlide', params:$this->params, show:$this->show);
    }

    public function render()
    {
        return view('livewire.components.slide-right');
    }
}
