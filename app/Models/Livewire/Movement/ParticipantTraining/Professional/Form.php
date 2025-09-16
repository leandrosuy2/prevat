<?php

namespace App\Livewire\Movement\ParticipantTraining\Professional;

use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\Movements\TrainingProfessionalsRepository;
use App\Repositories\ProfessionalRepository;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide;

    public $state = [
        'professional_id' => '',
        'front' => false,
        'verse' => false
    ];

    public $trainingParticipation;
    public $professional;

    public function mount($id = null, $professional_id = null)
    {
//        dd($id, $professional_id);
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingParticipationRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }

        $professionalRepository = new TrainingProfessionalsRepository();
        $professionalReturnDB = $professionalRepository->show($professional_id)['data'];

        $this->professional = $professionalReturnDB;

        if($this->professional){
            $this->state = $this->professional->toArray();
        }
    }

    public function getSelectProfessionals()
    {
        $professionalRepository = new ProfessionalRepository();
        return $professionalRepository->getSelectProfessional();
    }

    public function getSelectProfessioanlFormation()
    {
        $professionalQualificationRepository = new ProfessionalRepository();
        $returnDB =  $professionalQualificationRepository->getSelecFormationByProfessional($this->state['professional_id']);

        return $returnDB;
    }

    public function submit()
    {
        if($this->professional) {
            return $this->update();
        }
        $requestValidated = $this->validate([
            'state.professional_id' => 'required',
            'state.professional_formation_id' => 'required',
            'state.front' => 'sometimes|nullable',
            'state.verse' => 'sometimes|nullable'
        ]);

        $trainingProfessionalsRepository = new TrainingProfessionalsRepository();

        if($this->trainingParticipation) {
            $trainingProfessionalsRepository->create($this->trainingParticipation->id, $requestValidated['state']);
            $this->dispatch('getProfessionalsByParticipation');
            $this->closeSlide();
        } else {
            $trainingProfessionalsRepository->addProfessional($requestValidated['state']);
            $this->dispatch('getProfessionals');
            $this->closeSlide();
        }
    }

    public function update()
    {
        $requestValidated = $this->validate([
            'state.professional_id' => 'required',
            'state.professional_formation_id' => 'required',
            'state.front' => 'sometimes|nullable',
            'state.verse' => 'sometimes|nullable'
        ]);

        $trainingProfessionalsRepository = new TrainingProfessionalsRepository();

        $trainingProfessionalsRepository->update($this->professional->id, $requestValidated['state']);
        $this->reset('state');
        $this->dispatch('getProfessionalsByParticipation');
        $this->closeSlide();

    }

    public function render()
    {
        $response = new \stdClass();
        $response->professionals = $this->getSelectProfessionals();
        $response->professionalFormations = $this->getSelectProfessioanlFormation();

        return view('livewire.movement.participant-training.professional.form', ['response' => $response]);
    }
}
