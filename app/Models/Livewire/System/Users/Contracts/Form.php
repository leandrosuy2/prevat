<?php

namespace App\Livewire\System\Users\Contracts;

use App\Repositories\CompanyContractRepository;
use App\Repositories\UserContractsRepository;
use App\Repositories\UserRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $state = [];

    public $user;

    public function mount($id = null, $user_id = null)
    {
        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->show($user_id)['data'];

        $this->user = $userReturnDB;
    }

    public function save()
    {
        $request = $this->state;

        $userContractsRepository = new UserContractsRepository();
        $userContractsReturnDB = $userContractsRepository->create($this->user->id, $request);

        if($userContractsReturnDB['status'] == 'success') {
            $this->dispatch('getContractsByUser');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $userContractsReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($userContractsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $userContractsReturnDB['message']);
            $this->closeModal();
        }
    }

    public function update()
    {
        $request = $this->state;
        $userContractsRepository = new UserContractsRepository();

        $userContractsReturnDB = $userContractsRepository->update($request, $this->contract->id);

        if($userContractsReturnDB['status'] == 'success') {
            $this->dispatch('getContractsByCompany');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $userContractsReturnDB['message']);
            $this->reset('state');
            return redirect()->back();
        } else if ($userContractsReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $userContractsReturnDB['message']);
            $this->closeModal();
        }
    }
    public function getSelectContractsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts($this->user->company_id, $this->user->id);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contracts = $this->getSelectContractsByCompany();

        return view('livewire.system.users.contracts.form', ['response' => $response]);
    }
}
