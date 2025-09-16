<?php

namespace App\Livewire\Registration\Country;

use App\Repositories\CountryRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'city',
        'order' => 'ASC'
    ];

    #[On('getCountries')]
    public function getCountries()
    {
        $countryRepository = new CountryRepository();
        $trainingRoomReturnDB = $countryRepository->index($this->order)['data'];

        return $trainingRoomReturnDB;
    }

    #[On('confirmDeleteCountry')]
    public function delete($id = null)
    {
        $countryRepository = new CountryRepository();
        $trainingRoomReturnDB = $countryRepository->delete($id);

        if($trainingRoomReturnDB['status'] == 'success') {
            return redirect()->route('registration.countries')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        } else if ($trainingRoomReturnDB['status'] == 'error') {
            return redirect()->route('registration.countries')->with($trainingRoomReturnDB['status'], $trainingRoomReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->countries = $this->getCountries();

        return view('livewire.registration.country.table', ['response' => $response]);
    }
}
