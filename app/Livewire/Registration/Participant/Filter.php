<?php

namespace App\Livewire\Registration\Participant;

use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRoleRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'company_id' => '',
        'participant_role_id' => '',
        'status' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilter');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableParticipants', filterData: $request);
    }

    public function getSelectCompanies()
    {
        $companyRepository = new CompanyRepository();
        return $companyRepository->getSelectCompany();
    }

    public function getSelectParticipantRoles()
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        return $participantRoleRepository->getSelectParticipantRole();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->participantRoles = $this->getSelectParticipantRoles();

        return view('livewire.registration.participant.filter', ['response' => $response]);
    }
}
