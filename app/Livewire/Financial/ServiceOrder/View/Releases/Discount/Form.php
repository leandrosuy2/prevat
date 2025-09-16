<?php

namespace App\Livewire\Financial\ServiceOrder\View\Releases\Discount;

use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $state = [
        'type' => 'value'
    ];

    public $service_order_id;

    public function mount($id)
    {
        $this->service_order_id = $id;
    }

    public function save()
    {
        $request = $this->state;

        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->addDiscount($this->service_order_id, $request);

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
        return view('livewire.financial.service-order.view.releases.discount.form');
    }
}
