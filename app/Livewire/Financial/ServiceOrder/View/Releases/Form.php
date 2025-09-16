<?php

namespace App\Livewire\Financial\ServiceOrder\View\Releases;

use App\Models\ServiceOrdersItems;
use App\Repositories\Financial\FinancialRepository;
use App\Repositories\Financial\ServiceOrderReleasesRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $filters;
    public $releases = [];
    public $filterReleases = [];
    public $orderService;

    public function mount($service_order_id, $id = null)
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->show($service_order_id)['data'];

        if($serviceOrderReturnDB) {
            $this->orderService = $serviceOrderReturnDB;
        }

        $serviceOrderItemsDB = ServiceOrdersItems::query()->where('service_order_id', $service_order_id)->pluck('schedule_company_id');
        $this->releases = $serviceOrderItemsDB;
    }

    #[On('filterTableReleasesView')]
    public function filterTableReleases($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterReleasesView')]
    public function clearFilterReleases($visible = null)
    {
        $this->filters = null;
    }

    #[On('getReleases')]
    public function getReleases()
    {
        $financialRepository = new FinancialRepository();
        $financialRepositoryReturnDB =  $financialRepository->getReleasesByCompany($this->orderService->company_id, $this->orderService->contract_id, $this->releases, $this->filters);

        $this->filterReleases = $financialRepositoryReturnDB;

        return $financialRepositoryReturnDB;
    }

    public function addRelease($id)
    {
        $this->releases[] =+ $id;

        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $serviceOrderItemsReturnDB = $serviceOrderReleasesRepository->create($this->orderService->id, $id);

        if($serviceOrderItemsReturnDB['status'] == 'success') {
            $this->dispatch('getReleasesByOrder');
            $this->dispatch('getServiceOrder');
            $this->dispatch('getServiceOrderTop');
            $this->dispatch('getParticipantsByReleases');
        } elseif ($serviceOrderItemsReturnDB['status'] == 'error') {

        }
    }

    public function addSelectionsRelease()
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $serviceOrderItemsReturnDB = $serviceOrderReleasesRepository->createSelections($this->orderService->id, $this->filterReleases->pluck('id'));

        if($serviceOrderItemsReturnDB['status'] == 'success') {
            $this->closeModal();
            $this->dispatch('getReleasesByOrder');
            $this->dispatch('getServiceOrder');
            $this->dispatch('getServiceOrderTop');
            $this->dispatch('getParticipantsByReleases');
            $this->sendNotificationSuccess('Sucesso !', $serviceOrderItemsReturnDB['message']);
        } elseif($serviceOrderItemsReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->danger('Erro !', $serviceOrderItemsReturnDB['message']);
        }

    }

    public function render()
    {
        $response = new \stdClass();
        $response->releases = $this->getReleases();

        return view('livewire.financial.service-order.view.releases.form', ['response' => $response]);
    }
}
