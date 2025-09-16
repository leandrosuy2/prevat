<?php

namespace App\Livewire\Client\Alerts\NoContracts;

use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Card extends Component
{
    public $company;

    public function mount()
    {
        $companyRepository = new CompanyRepository();
        $companyReturnDB = $companyRepository->show(Auth::user()->company_id);

        if($companyReturnDB){
            $this->company = $companyReturnDB['data'];
        }
    }

    public function render()
    {
        return view('livewire.client.alerts.no-contracts.card');
    }
}
