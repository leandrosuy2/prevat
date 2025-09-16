<?php

namespace App\Livewire\Movement\ScheduleCompany\Participants;

use App\Models\ScheduleCompanyParticipants;
use App\Repositories\ParticipantRepository;
use App\Repositories\ScheduleCompanyParticipantsRepository;
use App\Repositories\ScheduleCompanyRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    use WithSlide, Interactions;

    public $company_id;

    public $participants = [];
    public $scheduleCompany;
    public $scheduleCompanyParticipants = false;
    public $schedule_prevat_id;
    public $contract_id;

    public $filters;

    public function mount($schedule_company_id = null, $id = null, $contract_id = null, $edit = null)
    {
        $companyRepository = new ScheduleCompanyRepository();
        $companyReturnDB = $companyRepository->show($schedule_company_id)['data'];

        if($companyReturnDB) {
            $this->scheduleCompany = $companyReturnDB;
        }

        if($edit) {
            $this->scheduleCompanyParticipants = true;
        }

        $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->where('schedule_company_id', $schedule_company_id)->pluck('participant_id');
        $this->participants = $scheduleCompanyParticipantsDB;

       $this->company_id = $id;
       $this->contract_id = $contract_id ?? $companyReturnDB['contract_id'];
    }

    #[On('filterCardParticipants')]
    public function filtersParticipants($filterData)
    {
        $this->filters = $filterData;
    }

    #[On('addParticipantCreate')]
    public function addParticipant($participant_id = null)
    {
        $this->participants[] =+ $participant_id;

        if($this->scheduleCompany && $this->scheduleCompanyParticipants) {
            return $this->addParticipantEdit($participant_id);
        }
        $this->dispatch('addParticipant', participant_id:$participant_id);

    }
    #[On('remParticipantCard')]
    public function remParticipant($key)
    {
        unset($this->participants[$key]);
    }

    #[On('addParticipantEdit')]
    public function addParticipantEdit($participant_id = null)
    {
        $this->participants[] =+ $participant_id;

        $scheduleCompanyParticipantRepository = new ScheduleCompanyParticipantsRepository();
        $returnDB = $scheduleCompanyParticipantRepository->create($this->scheduleCompany->id, $participant_id);

        if($returnDB['status'] == 'success') {
            $this->dispatch('getParticipantsByTrainingCompany');
            $this->sendNotificationSuccess('Sucesso !', $returnDB['message']);
        } else if ($returnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro !', $returnDB['message']);
        }
    }

    #[On('getParticipants')]
    public function getParticipants()
    {
        $participantsRepository = new ParticipantRepository();
        return $participantsRepository->getParticipantActive($this->company_id, $this->contract_id, $this->participants, $this->filters);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipants();

        return view('livewire.movement.schedule-company.participants.card', ['response' => $response]);
    }
}
