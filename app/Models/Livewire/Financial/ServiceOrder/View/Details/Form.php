<?php

namespace App\Livewire\Financial\ServiceOrder\View\Details;

use App\Repositories\Financial\PaymentMethodRepository;
use App\Repositories\Financial\ServiceOrderContactRepository;
use App\Services\AddressService;
use App\Services\CNPJService;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide, Interactions;

    public  $state  = [
        'type' => '',
        'order' => [
            'payment_method_id' => ''
        ]
    ];

    public $contact;

    public function mount($id = null)
    {

        $serviceOrderContactRepository = new ServiceOrderContactRepository();
        $serviceOrderContactReturnDB = $serviceOrderContactRepository->show($id)['data'];

        $this->contact = $serviceOrderContactReturnDB;

        if ($this->contact) {
            $this->state = $this->contact->toArray();
        }
    }

    public function updatedStateType()
    {
//        if($this->state['type'] == 'CNPJ') {
//            $this->state['name'] = '';
//            $this->state['taxpayer_registration'] = '';
//            $this->state['responsible'] = '';
//        }

//        if($this->state['type'] == 'CPF') {
            $this->state['taxpayer_registration'] = '';
            $this->state['responsible'] = '';
            $this->state['name'] = '';
            $this->state['fantasy_name'] = '';
            $this->state['employer_number'] = '';
            $this->state['responsible'] = '';
//        }
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

    public function save()
    {
        if($this->contact){
            return $this->update();
        }

        $request = $this->state;

        $serviceOrderContactRepository = new ServiceOrderContactRepository();
        $serviceOrderContactReturnDB = $serviceOrderContactRepository->create($request);

        if($serviceOrderContactReturnDB['status'] == 'success') {
            $this->dispatch('getServiceOrder');
            $this->closeModal();

            $this->reset('state');
            $this->showToast('Sucesso', $serviceOrderContactReturnDB['message']);
            $this->redirectRoute('movement.schedule-company.create');
        } else if ($serviceOrderContactReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->showToast('Erro', $serviceOrderContactReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $serviceOrderContactRepository = new ServiceOrderContactRepository();

        $serviceOrderContactReturnDB = $serviceOrderContactRepository->update($request, $this->contact->id);

        if($serviceOrderContactReturnDB['status'] == 'success') {
            $this->dispatch('getServiceOrder');
            $this->closeModal();
            $this->reset('state');
            $this->sendNotificationSuccess('Erro', $serviceOrderContactReturnDB['message']);
        } else if ($serviceOrderContactReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->sendNotificationDanger('Erro', $serviceOrderContactReturnDB['message']);
        }
    }


    public function getSelectPaymentMethod()
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        return $paymentMethodRepository->getSelectPaymentMethod();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->paymentMethods = $this->getSelectPaymentMethod();

        return view('livewire.financial.service-order.view.details.form', ['response' => $response]);
    }
}
