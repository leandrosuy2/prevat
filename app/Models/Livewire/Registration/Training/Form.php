<?php

namespace App\Livewire\Registration\Training;

use App\Repositories\TechnicalManagerRepository;
use App\Repositories\TrainingCategoriesRepository;
use App\Repositories\TrainingRepository;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [
        'status' => '',
        'category_id' => '',
        'time_type' => '',
        'content' => ''
    ];

    public $image;

    public $training;

    public function mount($id = null)
    {
        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->show($id)['data'];
        $this->training = $trainingReturnDB;

        if($this->training){
            $this->state = $this->training->toArray();
            $this->state['value'] = formatMoneyInput($trainingReturnDB['value']);
        }
    }
    public function updatedImage()
    {
        if($this->image){
            $this->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->training){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $trainingRepository = new TrainingRepository();
        $trainingReturnDB = $trainingRepository->create($request, $validatedImage['image']);

        if($trainingReturnDB['status'] == 'success') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        } else if ($trainingReturnDB['status'] == 'error') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $trainingRepository = new TrainingRepository();

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $trainingReturnDB = $trainingRepository->update($request, $this->training->id, $validatedImage['image']);

        if($trainingReturnDB['status'] == 'success') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        } else if ($trainingReturnDB['status'] == 'error') {
            return redirect()->route('registration.training')->with($trainingReturnDB['status'], $trainingReturnDB['message']);
        }
    }

    public function getSelectCategories()
    {
        $trainingCategoriesRepository = new TrainingCategoriesRepository();
        return $trainingCategoriesRepository->getSelectTrainingCategories();
    }

    public function getSelectTechnicalsManager()
    {
        $technicalsManagerRepository = new TechnicalManagerRepository();
        return $technicalsManagerRepository->getSelectTechnicalManager();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getSelectCategories();
        $response->technicals = $this->getSelectTechnicalsManager();

        return view('livewire.registration.training.form', ['response' => $response]);
    }
}
