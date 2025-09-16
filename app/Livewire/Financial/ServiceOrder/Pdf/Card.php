<?php

namespace App\Livewire\Financial\ServiceOrder\Pdf;

use App\Models\ServiceOrder;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use Livewire\Component;

class Card extends Component
{
    use Interactions;

    public $serviceOrder;

    public function mount($id = null)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceReturnDB = $serviceOrderRepository->show($id)['data'];

        if($serviceReturnDB){
            $this->serviceOrder = $serviceReturnDB;
        }
    }

    public function downloadOS($service_order_id)
    {
        sleep(1);
        $serviceOrderDB = ServiceOrder::query()->withoutGlobalScopes()->findOrFail($service_order_id);

        $this->sendNotificationSuccess('Sucesso', 'Documento Baixado com sucesso!');
        return response()->download(storage_path($serviceOrderDB['os_path']));
    }

    public function render()
    {
        return view('livewire.financial.service-order.pdf.card');
    }
}
