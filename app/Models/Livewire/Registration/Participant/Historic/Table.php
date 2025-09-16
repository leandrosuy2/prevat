<?php

namespace App\Livewire\Registration\Participant\Historic;

use App\Repositories\Movements\TrainingParticipantsRepository;
use App\Repositories\ParticipantRepository;
use Livewire\Component;

class Table extends Component
{
    public $participant;

    public $pageSize = 12;

    public function mount($id = null)
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->show($id)['data'];

        if($participantReturnDB){
            $this->participant = $participantReturnDB;
        }
    }

    public function getHistoricsByParticipant()
    {
        $trainingParticipantRepository = new TrainingParticipantsRepository();
        return $trainingParticipantRepository->getTrainingsByParticipant($this->participant->id, $this->pageSize);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->historics = $this->getHistoricsByParticipant();

        return view('livewire.registration.participant.historic.table', ['response' => $response]);
    }
}
