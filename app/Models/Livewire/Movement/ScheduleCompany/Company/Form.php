<?php

namespace App\Livewire\Movement\ScheduleCompany\Company;

use App\Repositories\CompanyRepository;
use App\Services\AddressService;
use App\Services\CNPJService;
use App\Services\WsReceitaService;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide, Interactions;

    public $state = [
        'status' => '',
        'user' => [],
        'contract' => []
    ];
    public $company;
    public $selected = '';

    public function mount($id = null)
    {
        $companyRepository = new CompanyRepository();
        $userReturnDB = $companyRepository->show($id)['data'];
        $this->company = $userReturnDB;

        if($this->company){
            $this->state = $this->company->toArray();
        }
    }

    public function getCompany()
    {
        if(isset($this->state['employer_number'])){
            $CNPJService  = new CNPJService();
            $cnpjServiceReturn = $CNPJService->consultCNPJ($this->state['employer_number']);

            if(isset($cnpjServiceReturn['code']) == 503) {
                $this->sendNotificationDanger($cnpjServiceReturn['title'], $cnpjServiceReturn['message']);
            } else {
                $this->sendNotificationSuccess('Sucesso', 'Dados encotnrado com sucesso !');
                $this->state['name'] = $cnpjServiceReturn['RAZAO SOCIAL'] ?? '';
                $this->state['phone'] = formatPhone($cnpjServiceReturn['DDD'].$cnpjServiceReturn['TELEFONE'] ?? '');
                $this->state['email'] = $cnpjServiceReturn['EMAIL'] ?? '';
                $this->state['address'] = $cnpjServiceReturn['LOGRADOURO'] ?? '';
                $this->state['zip-code'] = formatZipCode($cnpjServiceReturn['CEP'] ?? '');
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

                $this->sendNotificationSuccess('Sucesso', 'Endereço encontrado com sucesso !');
                $this->state['address'] = $addressServiceReturn['data']['logradouro'];
                $this->state['neighborhood'] = $addressServiceReturn['data']['bairro'];
                $this->state['city'] = $addressServiceReturn['data']['localidade'];
                $this->state['uf'] = $addressServiceReturn['data']['uf'];

            } else if($addressServiceReturn['code'] == 400) {
                $this->sendNotificationDanger($addressServiceReturn['title'], $addressServiceReturn['message']);
            }
        }
    }

    public function updatedSelected()
    {
        $this->state['status'] = $this->selected;
    }

    public function save()
    {
        if($this->company){
            return $this->update();
        }

        $request = $this->state;

        $companyRepository = new CompanyRepository();
        $userReturnDB = $companyRepository->create($request);

        if($userReturnDB['status'] == 'success') {
            $this->dispatch('getParticipants');
            $this->dispatch('getSelectCompaniesss');
            $this->closeModal();

            $this->reset('state');
            $this->showToast('Sucesso', $userReturnDB['message']);
            $this->redirectRoute('movement.schedule-company.create');
        } else if ($userReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->showToast('Erro', $userReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $companyRepository = new CompanyRepository();

        $userReturnDB = $companyRepository->update($request, $this->company->id);

        if($userReturnDB['status'] == 'success') {
            $this->dispatch('getParticipants');
            $this->closeModal();
            $this->reset('state');
            $this->redirectRoute('movement.schedule-company.create');
        } else if ($userReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->showToast('Erro', $userReturnDB['message']);
        }
    }
    public function render()
    {
        return view('livewire.movement.schedule-company.company.form');
    }
}
