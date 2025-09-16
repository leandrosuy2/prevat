<?php

namespace App\Livewire\Movement\ParticipantTraining\Participants;

use App\Models\TrainingParticipants;
use App\Repositories\Movements\TrainingParticipantsRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\ParticipantRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $order = [
        'column' => 'name',
        'order' => 'DESC'
    ];

    public $filters;

    public $trainingParticipation;

    #[On('filterParticipantUOR')]
    public function filters($filter = null)
    {
        $this->filters = $filter;
    }

    public function mount($id = null, $company_id = null)
    {
        $trainingParticipationRepository = new TrainingParticipationsRepository();
        $trainingReturnDB = $trainingParticipationRepository->show($id)['data'];

        if($trainingReturnDB) {
            $this->trainingParticipation = $trainingReturnDB;
        }
    }
    #[On('getParticipantsByTraining')]
    public function getParticipants()
    {
        $trainingParticipantsDB = null;

        if($this->trainingParticipation) {
            $trainingParticipantsDB = TrainingParticipants::query()->where('training_participation_id', $this->trainingParticipation->id)->pluck('participant_id');
        } else {
            $trainingParticipantsDB = [];

            $participants = session()->get('participants');

            if($participants){
                foreach ($participants as $key => $participant) {
                    $trainingParticipantsDB[$key] = $participant['id'];
                }
            }
        }

        $participantsRepository = new ParticipantRepository();
        return $participantsRepository->getParticipantActive(null,  null, $trainingParticipantsDB, $this->filters);
    }


    public function addParticipant($participant_id = null )
    {
        $trainingParticipantsRepository = new TrainingParticipantsRepository();
        if($this->trainingParticipation) {
            $trainingParticipantsRepository->create($this->trainingParticipation->id, $participant_id);
            $this->dispatch('getParticipantsByParticipation');
        } else {
            $this->dispatch('addParticipantSession', participant_id: $participant_id);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipants();

        return view('livewire.movement.participant-training.participants.form', ['response' => $response]);
    }
}
