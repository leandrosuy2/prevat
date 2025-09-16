<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class SmallModal extends Component
{
    public $blade;
    public $params;
    public $show = 'hide';

    #[On('openSmallModal')]
    public function openSmallModal($blade = null, $params = null)
    {
        $this->blade = $blade;
        $this->params = $params;
        $this->show = 'show';

        $this->dispatch('showSmallModal', params:$this->params, show:$this->show);
    }

    #[On('closeSmallModal')]
    public function closeSmallModal($blade = null, $params = null)
    {
        $this->blade = '';
        $this->params = '';
        $this->show = 'hide';
        $this->dispatch('hideSmallModal', params:$this->params, show:$this->show);
    }

    public function render()
    {
        return view('livewire.components.small-modal');
    }
}
