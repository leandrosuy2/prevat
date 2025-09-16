<?php

namespace App\Livewire\Registration\TrainingLocation;

use App\Repositories\TrainingLocationRepository;
use App\Services\AddressService;
use App\Trait\Interactions;
use Livewire\Component;

class Form extends Component
{
    use Interactions;

    public $state = [
        'status' => '',
    ];

    public $trainingLocation;

    public function mount($id = null)
    {
        $trainingLocationRepository = new TrainingLocationRepository();
        $trainingLocationReturnDB = $trainingLocationRepository->show($id)['data'];
        $this->trainingLocation = $trainingLocationReturnDB;

        if($this->trainingLocation){
            $this->state = $this->trainingLocation->toArray();
        }
    }

    public function getAddress()
    {
        if(isset($this->state['zip-code'])){
            $addressService  = new AddressService();
            $addressServiceReturn = $addressService->consultCEP($this->state['zip-code']);

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
        if($this->trainingLocation){
            return $this->update();
        }

        $request = $this->state;

        $trainingLocationRepository = new TrainingLocationRepository();
        $trainingLocationReturnDB = $trainingLocationRepository->create($request);

        if($trainingLocationReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        } else if ($trainingLocationReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $trainingLocationRepository = new TrainingLocationRepository();

        $trainingLocationReturnDB = $trainingLocationRepository->update($request, $this->trainingLocation->id);

        if($trainingLocationReturnDB['status'] == 'success') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        } else if ($trainingLocationReturnDB['status'] == 'error') {
            return redirect()->route('registration.training-location')->with($trainingLocationReturnDB['status'], $trainingLocationReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.training-location.form');
    }
}
