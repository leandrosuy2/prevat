<?php

namespace App\Livewire\Movement\SchedulePrevat\Participants;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ParticipantRoleRepository;
use App\Repositories\SchedulePrevatRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public $state = [
        'company_id' => '',
        'contract_id' => '',
        'status' => ''
    ];
    public $participant;

    public function mount($id = null)
    {
        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->show($id)['data'];

        $this->participant = $participantReturnDB;

        if($this->participant){
            $this->state = $this->participant->toArray();
        }
    }

    public function update()
    {
        $request = $this->state;
        $schedulePrevatRepository = new ParticipantRepository();
        $schedulePrevatReturnDB = $schedulePrevatRepository->update($request, $this->participant->id);

        if($schedulePrevatReturnDB['status'] == 'success') {
            $this->closeModal();
            $this->dispatch('getParticipantsBySchedulePrevat');
            $this->sendNotificationSuccess('Sucesso!', $schedulePrevatReturnDB['message']);
        } else if ($schedulePrevatReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro!', $schedulePrevatReturnDB['message']);
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
        return $companyContractsRepository->getSelectContracts($this->participant['company_id']);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->participantRoles = $this->getSelectParticipantRole();
        $response->contracts = $this->getSelectContratsByCompany();

        return view('livewire.movement.schedule-prevat.participants.form',['response' => $response]);
    }
}
