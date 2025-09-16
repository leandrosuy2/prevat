<?php

namespace App\Livewire\Site\Training;

use App\Repositories\Manage\ProductImageRepository;
use App\Repositories\Site\TrainingRepository;
use Livewire\Component;

class View extends Component
{
    public $training;
    public function mount($id = null)
    {
        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->show($id);

        if($trainingReturnDB) {
            $this->training = $trainingReturnDB['data'];
        }
    }

    public function getSixRamdonProducts()
    {
        $trainingRepository = new TrainingRepository();
        return $trainingRepository->getSixProductsByTraining($this->training['category_id']);
    }

    public function getImagesByProduct()
    {
        $productImageRepository = new ProductImageRepository();
        return $productImageRepository->index($this->training->id)['data'];
    }
    public function render()
    {
        $response = new \stdClass();
        $response->products = $this->getSixRamdonProducts();
        $response->images = $this->getImagesByProduct();

        return view('livewire.site.training.view', ['response' => $response]);
    }
}
