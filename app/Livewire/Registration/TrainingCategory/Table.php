<?php

namespace App\Livewire\Registration\TrainingCategory;

use App\Repositories\TrainingCategoriesRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTrainingCategories')]
    public function getTrainingCategories()
    {
        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        $trainingCategoriesReturnDB = $trainingCategoriesRepository->index($this->order)['data'];

        return $trainingCategoriesReturnDB;
    }

    #[On('confirmDeleteTrainingCategory')]
    public function delete($id = null)
    {
        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        $trainingCategoriesReturnDB = $trainingCategoriesRepository->delete($id);

        if($trainingCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-category')->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        } else if ($trainingCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getTrainingCategories();

        return view('livewire.registration.training-category.table', ['response' => $response]);
    }
}
