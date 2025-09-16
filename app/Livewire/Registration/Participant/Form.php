<?php

namespace App\Livewire\Registration\Participant;

use App\Repositories\CompanyContractRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ParticipantRoleRepository;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
        'company_id' => '',
        'contract_id' => '',
        'participant_role_id' => ''
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

    public function save()
    {
        if($this->participant){
            return $this->update();
        }

        $request = $this->state;

        $participantRepository = new ParticipantRepository();
        $participantReturnDB = $participantRepository->create($request);

        if($participantReturnDB['status'] == 'success') {
            return redirect()->route('registration.participant')->with($participantReturnDB['status'], $participantReturnDB['message']);
        } else if ($participantReturnDB['status'] == 'error') {
            return redirect()->route('registration.participant')->with($participantReturnDB['status'], $participantReturnDB['message']);
        }
    }

    public function removeSignature()
    {
        if (!$this->participant) {
            return;
        }

        $currentPath = $this->participant->signature_image ?? null;
        if ($currentPath && Storage::disk('public')->exists($currentPath)) {
            Storage::disk('public')->delete($currentPath);
        }

        $model = Participant::query()->find($this->participant->id);
        if ($model) {
            $model->update(['signature_image' => null]);
            $this->participant = $model->fresh();
        }

        // Reflect immediately in state/UI
        $this->state['signature'] = null;
        session()->flash('success', 'Assinatura removida com sucesso!');
    }

    public function update()
    {
        $request = $this->state;
        $participantRepository = new ParticipantRepository();

        $participantReturnDB = $participantRepository->update($request, $this->participant->id);

        if($participantReturnDB['status'] == 'success') {
            return redirect()->route('registration.participant')->with($participantReturnDB['status'], $participantReturnDB['message']);
        } else if ($participantReturnDB['status'] == 'error') {
            return redirect()->route('registration.participant')->with($participantReturnDB['status'], $participantReturnDB['message']);
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

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->participantRoles = $this->getSelectParticipantRole();
        $response->contracts = $this->getContratsByCompany();

        return view('livewire.registration.participant.form', ['response' => $response]);
    }
}
