<?php

namespace App\Livewire\Client\Components\Selects\Contracts;

use App\Repositories\CompanyContractRepository;
use App\Repositories\UserContractsRepository;
use App\Trait\Interactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $contract_id;

    public function mount()
    {
        $this->contract_id = Auth::user()->contract_id;
    }
    public function updatedContractID()
    {
        $userContractsRepository = new UserContractsRepository();
        if($this->contract_id != null) {
            $userContractReturnDB = $userContractsRepository->changeContract(Auth::user()->id, $this->contract_id);

            if($userContractReturnDB['status'] == 'success') {
                return redirect()->route('dashboard')->with($userContractReturnDB['status'], $userContractReturnDB['message']);
            } else if ($userContractReturnDB['status'] == 'error') {
                $this->sendNotificationDanger('Erro', $userContractReturnDB['message']);
            }
        }
    }
    public function getSelectContracts()
    {
        $userContractsRepository = new UserContractsRepository();
        return $userContractsRepository->getSelectContracts(Auth::user()->id);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contracts = $this->getSelectContracts();

        return view('livewire.client.components.selects.contracts.form', ['response' => $response]);
    }
}
