<?php

namespace App\Livewire\Financial\ServiceOrder\View\Details;

use MissaelAnda\Whatsapp\Messages;
use App\Models\ServiceOrder;
use App\Repositories\Financial\PaymentMethodRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use MissaelAnda\Whatsapp\Whatsapp;

class Card extends Component
{
    use WithSlide, Interactions;

    public $service_order_id;

    public function mount($id = null)
    {
        $this->service_order_id = $id;
    }

    #[On('getServiceOrder')]
    public function getServiceOrder()
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        return $serviceOrderRepository->show($this->service_order_id)['data'];
    }

    public function getSelectPaymentMethod()
    {
        $paymentMethodRepository = new PaymentMethodRepository();
        return $paymentMethodRepository->getSelectPaymentMethod();
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

    public function sendWhatsapp()
    {

    }

    public function downloadOS($service_order_id)
    {
        sleep(1);
        $serviceOrderDB = ServiceOrder::query()->withoutGlobalScopes()->findOrFail($service_order_id);

        $this->sendNotificationSuccess('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($serviceOrderDB['os_path']));
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

    public function render()
    {
        $response = new \stdClass();
        $response->serviceOrder = $this->getServiceOrder();
        $response->paymentMethods = $this->getSelectPaymentMethod();

        return view('livewire.financial.service-order.view.details.card', ['response' => $response]);
    }
}
