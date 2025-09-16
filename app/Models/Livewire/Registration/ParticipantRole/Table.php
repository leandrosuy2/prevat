<?php

namespace App\Livewire\Registration\ParticipantRole;

use App\Repositories\ParticipantRoleRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getParticipantRole')]
    public function getParticipantRole()
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        $participantRoleReturnDB = $participantRoleRepository->index($this->order)['data'];

        return $participantRoleReturnDB;
    }

    #[On('confirmDeleteParticipantRole')]
    public function delete($id = null)
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        $participantRoleReturnDB = $participantRoleRepository->delete($id);

        if($participantRoleReturnDB['status'] == 'success') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        } else if ($participantRoleReturnDB['status'] == 'error') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participantRoles = $this->getParticipantRole();

        return view('livewire.registration.participant-role.table', ['response' => $response]);
    }
}
