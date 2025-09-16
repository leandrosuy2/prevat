<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmModal extends Component
{
    public $title;
    public $pharse;
    public $id;
    public $action;

    public $params;
    public $show = 'hide';

    #[On('openConfirmDeleteModal')]
    public function openConfirmDeleteModal($title = null, $pharse = null, $id = null, $action = null)
    {
        $this->title = $title;
        $this->pharse = $pharse;
        $this->id = $id;
        $this->action = $action;
        $this->show = 'show';

        $this->dispatch('showConfirmDeleteModal', show:$this->show);
    }

    public function delete()
    {
        $this->show = 'hide';
        $this->dispatch('hideConfirmDeleteModal', show:$this->show);
        $this->dispatch($this->action, id:$this->id, show:$this->show);
    }

    #[On('closeConfirmDeleteModal')]
    public function closeModal($blade = null, $params = null)
    {
        $this->show = 'hide';
        $this->dispatch('hideConfirmDeleteModal', params:$this->params, show:$this->show);
    }

    public function render()
    {
        return view('livewire.components.confirm-modal');
    }
}
