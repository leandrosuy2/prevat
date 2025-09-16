<?php

namespace App\Livewire\Client\ScheduleCompany\Participants;

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
    public $scheduleCompanyParticipants;
    public $schedule_prevat_id;

    public $filters;

    public function mount($schedule_company_id = null, $id = null, $edit = null)
    {
        $companyRepository = new ScheduleCompanyRepository();
        $companyReturnDB = $companyRepository->show($schedule_company_id)['data'];

        if($companyReturnDB) {
            $this->scheduleCompany = $companyReturnDB;

            $scheduleCompanyParticipantsDB = ScheduleCompanyParticipants::query()->where('schedule_company_id', $schedule_company_id)->pluck('participant_id');
            $this->participants = $scheduleCompanyParticipantsDB;
        }

        if($edit) {
            $this->scheduleCompanyParticipants = true;
        }

        $this->company_id = $id;
    }

    #[On('filterCardParticipantsClient')]
    public function filtersParticipants($filterData)
    {
        $this->filters = $filterData;
    }

    public function addParticipant($participant_id = null)
    {
        if($this->scheduleCompany && $this->scheduleCompanyParticipants) {
            return $this->addParticipantEdit($participant_id);
        }
        $this->dispatch('addParticipantClient', participant_id:$participant_id);
        $this->participants[] =+ $participant_id;
    }

    #[On('remParticipantCardClient')]
    public function remParticipant($key)
    {
        unset($this->participants[$key]);
    }

    #[On('addParticipantEditClient')]
    public function addParticipantEdit($participant_id = null)
    {
        $this->participants[] =+ $participant_id;

        $scheduleCompanyParticipantRepository = new ScheduleCompanyParticipantsRepository();
        $returnDB = $scheduleCompanyParticipantRepository->create($this->scheduleCompany->id, $participant_id);

        if($returnDB['status'] == 'success') {
            $this->dispatch('getParticipantsByTrainingCompanyClient');
            $this->sendNotificationSuccess('Sucesso !', $returnDB['message']);
        } else if ($returnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro !', $returnDB['message']);
        }
    }

    #[On('getParticipantsClient')]
    public function getParticipants()
    {
        $participantsRepository = new ParticipantRepository();
        return $participantsRepository->getParticipantActive(null,null, $this->participants, $this->filters);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipants();

        return view('livewire.client.schedule-company.participants.card', ['response' => $response]);
    }
}
