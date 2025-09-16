<?php

namespace App\Livewire\Registration\TrainingRoom;

use App\Repositories\TrainingRoomRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $trainingRoom;

    public function mount($id = null)
    {
        $trainingRoomRepository = new TrainingRoomRepository();
        $trainingRoomReturnDB = $trainingRoomRepository->show($id)['data'];
        $this->trainingRoom = $trainingRoomReturnDB;

        if($this->trainingRoom){
            $this->state = $this->trainingRoom->toArray();
        }
    }

    public function save()
    {
        if($this->trainingRoom){
            return $this->update();
        }

        $request = $this->state;

        $trainingRoomRepository = new TrainingRoomRepository();
        $trainingRoomReturnDB = $trainingRoomRepository->create($request);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-room')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-room')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $trainingRoomRepository = new TrainingRoomRepository();

        $trainingRoomReturnDB = $trainingRoomRepository->update($request, $this->trainingRoom->id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-room')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-room')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.training-room.form');
    }
}
