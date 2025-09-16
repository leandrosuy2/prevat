<?php

namespace App\Livewire\Components\Selects\Contracts;

use App\Repositories\ContractorsRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $contractor_id;

    public function updatedContractorID()
    {
        $this->dispatch('filterScheduleTrainingByContractor', contractor_id:$this->contractor_id);
    }
    public function getSelectContractors()
    {
        $contractorsRepository = new ContractorsRepository();
        return $contractorsRepository->getSelectContractor();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contractors = $this->getSelectContractors();

        return view('livewire.components.selects.contracts.form', ['response' => $response]);
    }
}
