<?php

namespace App\Livewire\Client\ScheduleCompany\Participant;

use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ParticipantRoleRepository;
use App\Repositories\ScheduleCompanyParticipantsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $state = [
        'status' => '',
        'company_id' => '',
        'participant_role_id' => ''
    ];

    public $company;
    public $schedule_company_id;

    public function mount($schedule_company_id = null, $id = null)
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show($id)['data'];
        $this->company = $companyReturnDB->toArray();
        $this->schedule_company_id = $schedule_company_id;

        if($this->company){
            $this->state['company_id'] = $this->company['id'];
        }
    }

    public function save()
    {
        $request = $this->state;

        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->create($request);

        if($participantReturnDB['status'] == 'success') {
            $this->dispatch('getParticipants');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $participantReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($participantReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantReturnDB['message']);
            $this->closeModal();
        }
    }

    public function createAdded()
    {
        $request = $this->state;

        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->create($request);

        if($participantReturnDB['status'] == 'success') {
            $this->dispatch('getParticipantsClient');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $participantReturnDB['message']);
            if($this->schedule_company_id) {
                $scheduleCompanyParticipantRepository = new ScheduleCompanyParticipantsRepository();
                $scheduleCompanyParticipantRepository->create($this->schedule_company_id, $participantReturnDB['data']['id']);
                $this->dispatch('getParticipantsByTrainingCompanyClient');
            } else {
                $this->dispatch('addParticipantClient', participant_id:$participantReturnDB['data']['id']);
            }
            $this->reset('state');
            return redirect()->back();
        } else if ($participantReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $participantReturnDB['message']);
            $this->closeModal();
        }
    }



    public function getSelectCompanies()
    {
        $companyRepository = new CompanyRepository();
        return $companyRepository->getSelectCompany();
    }

    public function getSelectParticipantRole()
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        return $participantRoleRepository->getSelectParticipantRole();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->participantRoles = $this->getSelectParticipantRole();

        return view('livewire.client.schedule-company.participant.form', ['response' => $response]);
    }
}
