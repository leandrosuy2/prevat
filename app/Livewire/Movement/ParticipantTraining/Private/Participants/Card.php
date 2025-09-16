<?php

namespace App\Livewire\Movement\ParticipantTraining\Private\Participants;

use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    public $filters;
    public $company;
    public $contract_id;
    public function mount($id = null, $contract_id = null)
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show($id)['data'];
        if($companyReturnDB) {
            $this->company = $companyReturnDB;
        }

        $this->contract_id = $contract_id;
    }

    #[On('filterCardParticipantsTraining')]
    public function filtersParticipantsTraining($filterData)
    {
        $this->filters = $filterData;
    }

    public function addParticipant($participant_id = null )
    {
        $this->dispatch('addParticipantSessionPrivate', participant_id: $participant_id);
    }

    #[On('getParticipantsPrivate')]
    public function getParticipants()
    {
        $participantsRepository = new ParticipantRepository();

        $trainingParticipantsDB = [];

        $participants = session()->get('participants');

        if($participants){
            foreach ($participants as $key => $participant) {
                $trainingParticipantsDB[$key] = $participant['id'];
            }
        }

        return $participantsRepository->getParticipantActive($this->company->id, $this->contract_id, $trainingParticipantsDB, $this->filters);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipants();

        return view('livewire.movement.participant-training.private.participants.card', ['response' => $response]);
    }
}
