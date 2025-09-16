<?php

namespace App\Livewire\Registration\TrainingLocation;

use App\Repositories\TrainingLocationRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTrainingLocation')]
    public function getTrainingLocation()
    {
        $trainingLocationRepository = new TrainingLocationRepository();
        $trainingLocationReturnDB = $trainingLocationRepository->index($this->order)['data'];

        return $trainingLocationReturnDB;
    }

    #[On('confirmDeleteTrainingLocation')]
    public function delete($id = null)
    {
        $trainingLocationRepository = new TrainingLocationRepository();
        $trainingLocationReturnDB = $trainingLocationRepository->delete($id);

        if($trainingLocationReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        } else if ($trainingLocationReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainingLocations = $this->getTrainingLocation();

        return view('livewire.registration.training-location.table', ['response' => $response]);
    }
}
