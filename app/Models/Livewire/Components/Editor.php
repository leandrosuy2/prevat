<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Editor extends Component
{
    public $value;
    public $quillId;

    public function mount($value)
    {
        $this->value = $value;
        $this->quillId = 'quill-'.uniqid();
    }

    public function updatedValue($value)
    {
        $this->dispatch('changeTextArea', value:$value);
    }

    public function render()
    {
        return view('livewire.components.editor');
    }
}
