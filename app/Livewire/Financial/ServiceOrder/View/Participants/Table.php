<?php

namespace App\Livewire\Financial\ServiceOrder\View\Participants;

use App\Models\ServiceOrder;
use App\Repositories\Financial\FinancialParticipantsRepository;
use App\Repositories\Financial\ServiceOrderReleasesRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, Interactions;

    public $order = [
        'column' => 'schedule_company_id',
        'order' => 'asc'
    ];

    public $quantity = [];
    public $participant_id;
    public $pagesize = 10;
    public $filters;

    public $service_order_id;

    public function mount($id)
    {
        $this->service_order_id = $id;
    }

    #[On('filterTableParticipantsView')]
    public function filterTableParticipantsView($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterParticipantsView')]
    public function clearFilterParticipantsView($visible = null)
    {
        $this->filters = null;
    }

    public function updatedQuantity($value, $key)
    {
        if($value != null ) {
            $financialParticipantsRepository = new FinancialParticipantsRepository();
            $financialParticipantsRepository->calculateTotalValueByQuanity($this->participant_id[$key], $value, $this->service_order_id);
            $this->dispatch('getReleasesByOrder');
            $this->dispatch('getParticipantsByReleases');
            $this->dispatch('getServiceOrderTop');
        }
    }

    public function downloadExcel($service_order_id)
    {
        sleep(1);
        $serviceOrderDB = ServiceOrder::query()->withoutGlobalScopes()->findOrFail($service_order_id);

        $this->sendNotificationSuccess('Sucesso', 'Documento Baixado com sucesso!');
        return Storage::disk('public')->download($serviceOrderDB['participants_path']);
    }
    #[On('getParticipantsByReleases')]
    public function getParticipantsByReleases()
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $participants =  $serviceOrderReleasesRepository->getParticipantsByReleases($this->service_order_id, $this->order, $this->pagesize, $this->filters)['data'];

        foreach ($participants as $key => $participant) {
            $this->participant_id[$key] = $participant['id'];
            $this->quantity[$key] = formatNumber($participant['quantity']);
        }

        return $participants;
    }

    #[On('getServiceOrder')]
    public function getServiceOrder()
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        return $serviceOrderRepository->show($this->service_order_id)['data'];
    }

    public function render()
    {
        $response = new \stdClass();
        $response->participants = $this->getParticipantsByReleases();
        $response->order = $this->getServiceOrder();

        return view('livewire.financial.service-order.view.participants.table', ['response' => $response]);
    }
}
