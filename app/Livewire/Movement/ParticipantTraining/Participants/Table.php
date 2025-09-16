<?php

namespace App\Livewire\Movement\ParticipantTraining\Participants;

use App\Repositories\Movements\TrainingCertificationsRepository;
use App\Repositories\Movements\TrainingParticipantsRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;

    public $trainingParticipation;

    public $quantity =[];
    public $note = [];
    public $presence = [];

    public $participant_id;

    public function mount($id = null)
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingParticipationRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }
    }

    public function updatedQuantity($value, $key)
    {
        if($value != null ) {
            $trainingParticipationRepository = new TrainingParticipantsRepository();
            $trainingParticipationRepository->calculateTotalValue($this->participant_id[$key], $value);
        }
    }

    public function updatedPresence($value, $key)
    {
        $scheduleCompanyRepository = new TrainingParticipantsRepository();
        $scheduleCompanyRepository->validatePresence($this->participant_id[$key], $value);

        $this->validate([
            'presence.*' => 'sometimes',
            'note.*' => 'required_if:presence.*,true',
        ]);
    }
    public function updatedNote($value, $key)
    {
        $trainingParticipationRepository = new TrainingParticipantsRepository();
        $trainingParticipationRepository->addNote($this->participant_id[$key], $value);
    }
    #[On('getParticipantsByParticipation')]
    public function getParticipantsByParticipation()
    {
        $trainingParticipationRepository = new TrainingParticipantsRepository();
        $participants = $trainingParticipationRepository->getParticipants($this->trainingParticipation->id)['data'];

        foreach ($participants as $key => $participant) {
            $this->quantity[$key] = $participant['quantity'];
            $this->note[$key] = $participant['note'];
            $this->participant_id[$key] = $participant['id'];
            $this->presence[$key] = $participant['presence'];
         }
        return $participants;
    }

    public function deleteParticipant($participant_id)
    {
        $trainingParticipationRepository = new TrainingParticipantsRepository();
        $participantsReturnDB = $trainingParticipationRepository->delete($participant_id);

        if($participantsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantsReturnDB['message']);
            $this->dispatch('getParticipantsByTraining');
        } else if ($participantsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantsReturnDB['message']);
        }
    }

    public function clearParticipants()
    {
        $trainingParticipationRepository = new TrainingParticipantsRepository();
        $participantsReturnDB = $trainingParticipationRepository->deleteAll($this->trainingParticipation->id);

        if($participantsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantsReturnDB['message']);
        } else if ($participantsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantsReturnDB['message']);
        }
    }

    public function addParticipants($schedule_prevat_id)
    {
        $trainingParticipationRepository = new TrainingParticipantsRepository();
        $participantsReturnDB = $trainingParticipationRepository->createAll($schedule_prevat_id, $this->trainingParticipation->id);

        if($participantsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantsReturnDB['message']);
        } else if ($participantsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantsReturnDB['message']);
        }
    }

    public function save()
    {
        $requestValidated = $this->validate([
            'quantity.*' => 'required',
            'presence.*' => 'sometimes',
            'note.*' => 'required_if:presence.*,true',

        ]);

        $trainingCertificateRepository = new TrainingCertificationsRepository();
        $trainingCertificateReturnDB = $trainingCertificateRepository->update($this->trainingParticipation->id);

        if($trainingCertificateReturnDB['status'] == 'success') {
            return redirect()->route('movement.participant-training')->with($trainingCertificateReturnDB['status'], $trainingCertificateReturnDB['message']);
        } else if ($trainingCertificateReturnDB['status'] == 'error') {
            return redirect()->back()->with($trainingCertificateReturnDB['status'], $trainingCertificateReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByParticipation();

        return view('livewire.movement.participant-training.participants.table', ['response' => $response]);
    }
}
