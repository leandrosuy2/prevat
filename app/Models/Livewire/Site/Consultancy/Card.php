<?php

namespace App\Livewire\Site\Consultancy;

use App\Repositories\Manage\ConsultancyRepository;
use Livewire\Component;

class Card extends Component
{
    public function getConsultancies()
    {
        $consultanciesRepository = new ConsultancyRepository();
        return $consultanciesRepository->getConsultanciesActive();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->consultancies = $this->getConsultancies();

        return view('livewire.site.consultancy.card', ['response' => $response]);
    }
}
