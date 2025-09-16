<?php

namespace App\Livewire\Financial\ServiceOrder\View\Releases;

use App\Repositories\Financial\ServiceOrderReleasesRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;

    public $order = [
        'column' => 'id',
        'order' => 'asc'
    ];

    public $filters;

    public $service_order_id;

    public function mount($id = null)
    {
        $this->service_order_id = $id;
    }

    #[On('filterTableReleasesView')]
    public function filterTableReleasesView($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterReleasesView')]
    public function clearFilterReleasesView($visible = null)
    {
        $this->filters = null;
    }

    #[On('getReleasesByOrder')]
    public function getReleasesByOrder()
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        return $serviceOrderReleasesRepository->index($this->service_order_id)['data'];
    }
    #[On('getServiceOrder')]
    public function getServiceOrder()
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        return $serviceOrderRepository->show($this->service_order_id)['data'];
    }

    public function confirmDelete($id = null ): void
    {
        $this->openConfirmDeleteModal('Atenção', 'Deseja deseja realmente deletar o item selecionado ?', $id, 'deleteRelease');
    }

    #[On('deleteRelease')]
    public function delete($id = null)
    {
        $serviceOrderReleasesRepository = new ServiceOrderReleasesRepository();
        $serviceOrderReleasesReturnDB = $serviceOrderReleasesRepository->delete($id);

        if($serviceOrderReleasesReturnDB['status'] == 'success') {
            $this->sendNotificationSuccess($serviceOrderReleasesReturnDB['status'], $serviceOrderReleasesReturnDB['message']);
            $this->dispatch('getParticipantsByReleases');
            $this->dispatch('getServiceOrder');
            $this->dispatch('getServiceOrderTop');
            $this->dispatch('getParticipantsByReleases');
        } elseif ($serviceOrderReleasesReturnDB['status'] == 'error') {
            $this->sendNotificationDanger($serviceOrderReleasesReturnDB['status'], $serviceOrderReleasesReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->releases = $this->getReleasesByOrder();
        $response->order = $this->getServiceOrder();

        return view('livewire.financial.service-order.view.releases.table', ['response' => $response]);
    }
}
