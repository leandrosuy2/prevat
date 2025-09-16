<?php

namespace App\Livewire\Site\Training;

use App\Repositories\Site\TrainingRepository;
use Livewire\Component;

class Menu extends Component
{
    public function getCategoriesFeatured()
    {
        $trainingRepository = new TrainingRepository();
        return $trainingRepository->getCategoriesProduct();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getCategoriesFeatured();

        return view('livewire.site.training.menu', ['response' => $response]);
    }
}
