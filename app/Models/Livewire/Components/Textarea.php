<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Textarea extends Component
{
    public $value;
    public $textAID;

    public function mount($value)
    {
        $this->value = $value;
        $this->textAID = 'quill-'.uniqid();
    }

    public function updatedValue($value)
    {
        dd($value);
        $this->dispatch('changeTextArea', value:$value);
    }

    public function render()
    {
        return view('livewire.components.textarea');
    }
}
