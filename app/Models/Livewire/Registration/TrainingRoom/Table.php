<?php

namespace App\Livewire\Registration\TrainingRoom;

use App\Repositories\TrainingRoomRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getTrainingRoom')]
    public function getTrainingRoom()
    {
        $trainingRoomRepository = new TrainingRoomRepository();
        $countryReturnDB = $trainingRoomRepository->index($this->order)['data'];

        return $countryReturnDB;
    }

    #[On('confirmDeleteTrainingRoom')]
    public function delete($id = null)
    {
        $trainingRoomRepository = new TrainingRoomRepository();
        $countryReturnDB = $trainingRoomRepository->delete($id);

        if($countryReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-room')->with($countryReturnDB['status'], $countryReturnDB['message']);
        } else if ($countryReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-room')->with($countryReturnDB['status'], $countryReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->trainingRooms = $this->getTrainingRoom();

        return view('livewire.registration.training-room.table', ['response' => $response]);
    }
}
