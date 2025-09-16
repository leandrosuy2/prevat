<?php

namespace App\Livewire\Site\Training;

use App\Repositories\Site\ProductCategoriesRepository;
use App\Repositories\Site\TrainingRepository;
use Livewire\Component;
use Livewire\WithPagination;

class Training extends Component
{
    use WithPagination;

    public $category;

    public $pageSize = 9;
    public function mount($id = null)
    {
        $productCategoryRepository = new ProductCategoriesRepository();
        $productCategoryReturnDB = $productCategoryRepository->show($id);
        if($productCategoryReturnDB) {
            $this->category = $productCategoryReturnDB['data'];
        }
    }

    public function getTrainingsByCategory()
    {
        $trainingRepository = new TrainingRepository();
        return $trainingRepository->getTrainingsByCategory($this->category->id ?? null , $this->pageSize);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainings = $this->getTrainingsByCategory();

        return view('livewire.site.training.training', ['response' => $response]);
    }
}
