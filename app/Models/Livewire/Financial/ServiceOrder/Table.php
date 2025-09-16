<?php

namespace App\Livewire\Financial\ServiceOrder;

use App\Models\ServiceOrder;
use App\Repositories\Financial\PaymentMethodRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSlide, Interactions;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableServiceOrder')]
    public function filterTableServiceOrder($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterServiceOrder')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getServiceOrder')]
    public function getServiceOrders()
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        return $serviceOrderRepository->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    public function updateStatus($data)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->updateStatus($data['id'], $data['status_id']);

        if($serviceOrderReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso', $serviceOrderReturnDB['message']);
        } elseif ($serviceOrderReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $serviceOrderReturnDB['message']);
        }
    }

    public function sendEmail($service_order_id)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->sendEmail($service_order_id);

        if($serviceOrderReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess('Sucesso !', $serviceOrderReturnDB['message']);
        } elseif ($serviceOrderReturnDB['status'] == 'error'){
            $this->sendNotificationDanger('Erro !', $serviceOrderReturnDB['message']);

        }
    }
    public function confirmDelete($id = null ): void
    {
        $this->openConfirmDeleteModal('Atenção', 'Deseja deseja realmente deletar a ordem de serviço selecionada ?', $id, 'deleteServiceOrder');
    }

    #[On('deleteServiceOrder')]
    public function delete($id = null)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->delete($id);

        if($serviceOrderReturnDB['status'] == 'success') {
            return redirect()->route('financial.service-order')->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        } else if ($serviceOrderReturnDB['status'] == 'error') {
            return redirect()->route('financial.service-order')->with($serviceOrderReturnDB['status'], $serviceOrderReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->serviceOrders = $this->getServiceOrders();

        return view('livewire.financial.service-order.table', ['response' => $response]);
    }
}
