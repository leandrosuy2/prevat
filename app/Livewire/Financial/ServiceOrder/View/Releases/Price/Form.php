<?php

namespace App\Livewire\Financial\ServiceOrder\View\Releases\Price;

use App\Repositories\Financial\ServiceOrderReleasesRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public $state = [];

    public $release;

    public function mount($id = null)
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $serviceOrderReturnDB = $serviceOrderReleasesRepository->show($id)['data'];

        $this->release = $serviceOrderReturnDB;

        if($this->release){
            $this->state['price'] = formatMoneyInput($serviceOrderReturnDB['schedule_company']['price']);
        }
    }

    public function save()
    {
        $request = $this->state;

        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $serviceOrderReturnDB = $serviceOrderReleasesRepository->update($request, $this->release->id);

        if($serviceOrderReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $serviceOrderReturnDB['message']);
            $this->dispatch('getReleasesByOrder');
            $this->dispatch('getParticipantsByReleases');
            $this->closeSmallModal();
        } elseif ($serviceOrderReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $serviceOrderReturnDB['message']);
            $this->closeSmallModal();
        }
    }

    public function render()
    {
        return view('livewire.financial.service-order.view.releases.price.form');
    }
}
