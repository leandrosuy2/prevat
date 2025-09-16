<?php

namespace App\Livewire\Movement\WithdrawalProtocol;

use App\Repositories\CompanyContractRepository;
use App\Repositories\Movements\EvidenceRepository;
use App\Repositories\Movements\TrainingParticipationsRepository;
use App\Repositories\WithdrawalProtocolRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'training_participation_id' => '',
        'company_id' => '',
        'contract_id' => '',
    ];

    public $protocol;

    public $file;

    public function mount($id = null)
    {
        $withdrawalProtocolRepository = new WithdrawalProtocolRepository();
        $evidenceReturnDB = $withdrawalProtocolRepository->show($id)['data'];
        $this->protocol = $evidenceReturnDB;

        if($this->protocol){
            $this->state = $this->protocol->toArray();
        }
    }

    public function updatedStateTrainingParticipationID()
    {
        $withdrawalProtocolRepository = new WithdrawalProtocolRepository();
        $return = $withdrawalProtocolRepository->show($this->state['training_participation_id'])['data'];

        $this->state['date'] = $return['date_event'] ?? '';
    }

    public function save()
    {
        if($this->protocol){
            return $this->update();
        }

        $request = $this->state;

        $withdrawalProtocolRepository = new WithdrawalProtocolRepository();
        $evidenceReturnDB = $withdrawalProtocolRepository->create($request);

        if($evidenceReturnDB['status'] == 'success') {
            return redirect()->route('movement.withdrawal-protocol')->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            return redirect()->back()->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $withdrawalProtocolRepository = new EvidenceRepository();
        $evidenceReturnDB = $withdrawalProtocolRepository->update($request, $this->protocol->id);

        if($evidenceReturnDB['status'] == 'success') {
            return redirect()->route('movement.withdrawal-protocol')->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        } else if ($evidenceReturnDB['status'] == 'error') {
            return redirect()->back()->with($evidenceReturnDB['status'], $evidenceReturnDB['message']);
        }
    }


    public function getSelectCompanies()
    {
        $trainingRepository = new TrainingParticipationsRepository();

        if($this->state['training_participation_id'] != null) {
            return $trainingRepository->getSelectCompabyByTraining($this->state['training_participation_id']);
        }

        return $trainingRepository->getSelectCompabyByTraining();
    }

    public function getSelectTraining()
    {
        $trainingRepository = new TrainingParticipationsRepository();
        return $trainingRepository->getSelectSchedulePrevat();
    }

    public function getContratsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->state['company_id']);
    }

    public function render()
    {
        $response = new  \stdClass();
        $response->companies = $this->getSelectCompanies();
        $response->trainings = $this->getSelectTraining();
        $response->contracts = $this->getContratsByCompany();

        return view('livewire.movement.withdrawal-protocol.form', ['response' => $response]);
    }
}
