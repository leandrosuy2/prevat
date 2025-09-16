<?php

namespace App\Livewire\Client\Company;

use App\Repositories\CompanyRepository;
use App\Services\AddressService;
use App\Trait\Interactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $state = [
        'status' => 'Ativo',
        'users' => []
    ];

    public $company;

    public function mount($id = null)
    {
        $companyRepository = new CompanyRepository();
        $userReturnDB = $companyRepository->show(Auth::user()->company_id)['data'];
        $this->company = $userReturnDB;

        if($this->company){
            $this->state = $this->company->toArray();
        }
    }

    public function getAddress()
    {
        if(isset($this->state['zip_code'])){
            $addressService  = new AddressService();
            $addressServiceReturn = $addressService->consultCEP($this->state['zip_code']);

            if($addressServiceReturn['code'] == 200) {

                $this->showToast('Sucesso', 'Endereço encontrado com sucesso !');
                $this->state['address'] = $addressServiceReturn['data']['logradouro'];
                $this->state['neighborhood'] = $addressServiceReturn['data']['bairro'];
                $this->state['city'] = $addressServiceReturn['data']['localidade'];
                $this->state['uf'] = $addressServiceReturn['data']['uf'];

            } else if($addressServiceReturn['code'] == 400) {
                $this->showToast($addressServiceReturn['title'], $addressServiceReturn['message']);
            }
        }
    }

    public function update()
    {
        $request = $this->state;
        $companyRepository = new CompanyRepository();

        $userReturnDB = $companyRepository->update($request, $this->company->id);

        if($userReturnDB['status'] == 'success') {
            return redirect()->route('company')->with($userReturnDB['status'], $userReturnDB['message']);
        } else if ($userReturnDB['status'] == 'error') {
            return redirect()->back()->with($userReturnDB['status'], $userReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.client.company.form');
    }
}
