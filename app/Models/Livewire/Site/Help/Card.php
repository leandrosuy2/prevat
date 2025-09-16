<?php

namespace App\Livewire\Site\Help;

use App\Repositories\Site\InfomationsRepository;
use Livewire\Component;

class Card extends Component
{
    public $information;

    public function mount()
    {
        $informationRepository = new InfomationsRepository();
        $informationReturnDB = $informationRepository->getFirst()['data'];

        if($informationReturnDB){
            $this->information = $informationReturnDB;
        }
    }

    public function render()
    {
        return view('livewire.site.help.card');
    }
}
