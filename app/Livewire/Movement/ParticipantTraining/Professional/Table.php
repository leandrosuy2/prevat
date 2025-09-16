<?php

namespace App\Livewire\Movement\ParticipantTraining\Professional;

use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\Movements\TrainingProfessionalsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;

    public $trainingParticipation;

    public function mount($id = null)
    {
        $trainingProfessionalsRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingProfessionalsRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }
    }

    #[On('getProfessionalsByParticipation')]
    public function getProfessionalsByParticipation()
    {
        $trainingProfessionalsRepository = new TrainingProfessionalsRepository();
        return  $trainingProfessionalsRepository->getProfessionals($this->trainingParticipation->id)['data'];
    }

    public function deleteProfessional($professional_id)
    {
        $trainingProfessionalsRepository = new TrainingProfessionalsRepository();
        $participantsReturnDB = $trainingProfessionalsRepository->delete($professional_id);

        if($participantsReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $participantsReturnDB['message']);
        } else if ($participantsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantsReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->professionals = $this->getProfessionalsByParticipation();

        return view('livewire.movement.participant-training.professional.table', ['response' => $response]);
    }
}
