<?php

namespace App\Livewire\Site\Register;

use App\Repositories\Site\SiteCompanyRepository;
use App\Services\AddressService;
use App\Services\CNPJService;
use App\Trait\Interactions;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $state = [
        'user' => []
    ];
    public function getCompany()
    {
        if(isset($this->state['employer_number'])){
            $CNPJService  = new CNPJService();
            $cnpjServiceReturn = $CNPJService->consultCNPJ($this->state['employer_number']);

            if(isset($cnpjServiceReturn['error'])) {
                return redirect()->back()->with('Erro', $cnpjServiceReturn['error']);
            } else {
                $this->showToast('Sucesso', 'Endereço encontrado com sucesso !');
                $this->state['name'] = $cnpjServiceReturn['RAZAO SOCIAL'] ?? '';

                if(isset($cnpjServiceReturn['TELEFONE'])){
                    $this->state['phone'] = formatPhone($cnpjServiceReturn['DDD'].$cnpjServiceReturn['TELEFONE'] ?? '');
                }

                $this->state['email'] = $cnpjServiceReturn['EMAIL'] ?? '';
                $this->state['address'] = $cnpjServiceReturn['LOGRADOURO'] ?? '';
                $this->state['zip_code'] = formatZipCode($cnpjServiceReturn['CEP'] ?? '');
                $this->state['number'] = $cnpjServiceReturn['NUMERO'] ?? '';
                $this->state['neighborhood'] = $cnpjServiceReturn['BAIRRO'] ?? '';
                $this->state['complement'] = $cnpjServiceReturn['COMPLEMENTO'] ?? '';
                $this->state['city'] = $cnpjServiceReturn['MUNICIPIO'] ?? '';
                $this->state['uf'] = $cnpjServiceReturn['UF'] ?? '';
            }
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

    public function submit()
    {
        $request = $this->state;

        $companyRepository = new SiteCompanyRepository();
        $userReturnDB = $companyRepository->create($request);

        if($userReturnDB['status'] == 'success') {
            return redirect()->route('thanks')->with($userReturnDB['status'], $userReturnDB['message']);
        } else if ($userReturnDB['status'] == 'error') {
            return redirect()->back()->with($userReturnDB['status'], $userReturnDB['code']);
        }
    }

    public function render()
    {
        return view('livewire.site.register.form');
    }
}
