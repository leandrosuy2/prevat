<?php

namespace App\Livewire\Movement\ParticipantTraining\Certificates;

use App\Repositories\Movements\TrainingParticipationsRepository;
use Livewire\Component;

class Printer extends Component
{
    public $trainingParticipation;

    public function mount($id = null)
    {
        $trainingProfessionalsRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingProfessionalsRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }
    }
    public function render()
    {
        return view('livewire.movement.participant-training.certificates.printer');
    }
}
