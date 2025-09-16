<?php

namespace App\Livewire\Registration\ParticipantRole;

use App\Repositories\ParticipantRoleRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $participantRole;

    public function mount($id = null)
    {
        $participantRoleRepository = new ParticipantRoleRepository();
        $participantRoleReturnDB = $participantRoleRepository->show($id)['data'];
        $this->participantRole = $participantRoleReturnDB;

        if($this->participantRole){
            $this->state = $this->participantRole->toArray();
        }
    }

    public function save()
    {
        if($this->participantRole){
            return $this->update();
        }

        $request = $this->state;

        $participantRoleRepository = new ParticipantRoleRepository();
        $participantRoleReturnDB = $participantRoleRepository->create($request);

        if($participantRoleReturnDB['status'] == 'success') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        } else if ($participantRoleReturnDB['status'] == 'error') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $participantRoleRepository = new ParticipantRoleRepository();

        $participantRoleReturnDB = $participantRoleRepository->update($request, $this->participantRole->id);

        if($participantRoleReturnDB['status'] == 'success') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        } else if ($participantRoleReturnDB['status'] == 'error') {
            return redirect()->route('registration.participant-role')->with($participantRoleReturnDB['status'], $participantRoleReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.participant-role.form');
    }
}
