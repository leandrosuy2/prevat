<?php

namespace App\Livewire\Financial\ServiceOrder;

use App\Repositories\Financial\ServiceOrderStatusRepository;
use App\Repositories\UserRepository;
use Livewire\Component;

class Filter extends Component
{
    public $filter = [
        'dates' => '',
        'status_id' => ''
    ];

    public function clearFilter()
    {
        $this->reset();
        $this->dispatch('clearFilterServiceOrder');
    }

    public function submit()
    {
        $request = $this->filter;
        $this->dispatch('filterTableServiceOrder', filterData: $request);
    }

    public function getSelectStatus()
    {
        $serviceStatusRepository = new ServiceOrderStatusRepository();
        return $serviceStatusRepository->getSelectServiceOrderStatus();
    }

    public function render()
    {
       $response = new \stdClass();
       $response->statuses = $this->getSelectStatus();

        return view('livewire.financial.service-order.filter', ['response' => $response]);
    }
}
