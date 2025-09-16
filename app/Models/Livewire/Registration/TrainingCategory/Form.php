<?php

namespace App\Livewire\Registration\TrainingCategory;

use App\Repositories\TrainingCategoriesRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $category;

    public function mount($id = null)
    {
        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        $trainingCategoriesReturnDB = $trainingCategoriesRepository->show($id)['data'];
        $this->category = $trainingCategoriesReturnDB;

        if($this->category){
            $this->state = $this->category->toArray();
        }
    }

    public function save()
    {
        if($this->category){
            return $this->update();
        }

        $request = $this->state;

        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        $trainingCategoriesReturnDB = $trainingCategoriesRepository->create($request);

        if($trainingCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-category')->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        } else if ($trainingCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $trainingCategoriesRepository = new TrainingCategoriesRepository();

        $trainingCategoriesReturnDB = $trainingCategoriesRepository->update($request, $this->category->id);

        if($trainingCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-category')->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        } else if ($trainingCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingCategoriesReturnDB['status'], $trainingCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.training-category.form');
    }
}
