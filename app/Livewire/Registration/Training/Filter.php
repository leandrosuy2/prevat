<?php

namespace App\Livewire\Registration\Training;

use App\Models\TrainingsCategory;
use App\Repositories\TrainingCategoriesRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'status' => '',
        'category_id' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableTrainings', filterData: $request);
    }

    public function getSelectTrainingCategories()
    {
        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        return $trainingCategoriesRepository->getSelectTrainingCategories();

    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getSelectTrainingCategories();

        return view('livewire.registration.training.filter', ['response' => $response]);
    }
}
