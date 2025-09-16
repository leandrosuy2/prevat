<?php

namespace App\Livewire\Movement\ScheduleCompany\Participant;

use App\Repositories\CompanyContractRepository;
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
        'contract_id' => '',
        'participant_role_id' => ''
    ];

    public $company;
    public $schedule_company_id;
    public $contract_id;

    public function mount($schedule_company_id = null, $id = null, $contract_id = null)
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show($id)['data'];

        $this->company = $companyReturnDB->toArray();
        $this->schedule_company_id = $schedule_company_id;
        $this->contract_id = $contract_id ?? $companyReturnDB['contract_id'];

        if($this->company){
            $this->state['company_id'] = $this->company['id'];
            $this->state['contract_id'] = $this->contract_id;
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
            $this->dispatch('getParticipants');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $participantReturnDB['message']);
            if($this->schedule_company_id) {
                $scheduleCompanyParticipantRepository = new ScheduleCompanyParticipantsRepository();
                $scheduleCompanyParticipantRepository->create($this->schedule_company_id, $participantReturnDB['data']['id']);
                $this->dispatch('getParticipantsByTrainingCompany');
            } else {
                $this->dispatch('addParticipant', participant_id:$participantReturnDB['data']['id']);
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

    public function getSelectContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->participantRoles = $this->getSelectParticipantRole();
        $response->contracts = $this->getSelectContratsByCompany();

        return view('livewire.movement.schedule-company.participant.form', ['response' => $response]);
    }
}
