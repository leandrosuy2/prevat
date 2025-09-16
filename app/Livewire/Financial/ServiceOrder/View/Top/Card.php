<?php

namespace App\Livewire\Financial\ServiceOrder\View\Top;

use App\Repositories\Financial\ServiceOrderReleasesRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    public $service_order_id;

    public function mount($id = null)
    {
        $this->service_order_id = $id;
    }

    #[On('getServiceOrderTop')]
    public function getServiceOrder()
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        return $serviceOrderRepository->show($this->service_order_id)['data'];
    }
    #[On('getParticipantsByReleases')]
    public function getParticipantsByReleases()
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        return  $serviceOrderReleasesRepository->getParticipantsByReleases($this->service_order_id)['data'];
    }

    public function render()
    {
        $response = new \stdClass();
        $response->serviceOrder = $this->getServiceOrder();
        $response->participants = $this->getParticipantsByReleases();

        return view('livewire.financial.service-order.view.top.card', ['response' => $response]);
    }
}
