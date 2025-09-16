<?php

namespace App\Livewire\Client\Participants;

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
        $this->dispatch('filterTableParticipantsByClient', filterData: $request);
    }

    public function getSelectParticipantRoles()
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        return $participantRoleRepository->getSelectParticipantRole();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participantRoles = $this->getSelectParticipantRoles();

        return view('livewire.client.participants.filter', ['response' => $response]);
    }
}
