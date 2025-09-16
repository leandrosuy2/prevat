<?php

namespace App\Livewire\Registration\Country;

use App\Repositories\CountryRepository;
use App\Services\AddressService;
use App\Trait\Interactions;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $state = [
        'status' => '',
    ];

    public $country;

    public function mount($id = null)
    {
        $countryRepository = new CountryRepository();
        $countryReturnDB = $countryRepository->show($id)['data'];
        $this->country = $countryReturnDB;

        if($this->country){
            $this->state = $this->country->toArray();
        }
    }

    public function getAddress()
    {
        if(isset($this->state['zip-code'])){
            $addressService  = new AddressService();
            $addressServiceReturn = $addressService->consultCEP($this->state['zip-code']);

            if($addressServiceReturn['code'] == 200) {

                $this->sendNotificationSuccess('Sucesso', 'Endereço encontrado com sucesso !');
                $this->state['city'] = $addressServiceReturn['data']['localidade'];
                $this->state['uf'] = $addressServiceReturn['data']['uf'];

            } else if($addressServiceReturn['code'] == 400) {
                $this->sendNotificationDanger($addressServiceReturn['title'], $addressServiceReturn['message']);
            }
        }
    }

    public function save()
    {
        if($this->country){
            return $this->update();
        }

        $request = $this->state;

        $countryRepository = new CountryRepository();
        $countryReturnDB = $countryRepository->create($request);

        if($countryReturnDB['status'] == 'success') {
            return redirect()->route('registration.countries')->with($countryReturnDB['status'], $countryReturnDB['message']);
        } else if ($countryReturnDB['status'] == 'error') {
            return redirect()->route('registration.countries')->with($countryReturnDB['status'], $countryReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $countryRepository = new CountryRepository();

        $countryReturnDB = $countryRepository->update($request, $this->country->id);

        if($countryReturnDB['status'] == 'success') {
            return redirect()->route('registration.countries')->with($countryReturnDB['status'], $countryReturnDB['message']);
        } else if ($countryReturnDB['status'] == 'error') {
            return redirect()->route('registration.countries')->with($countryReturnDB['status'], $countryReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.country.form');
    }
}
