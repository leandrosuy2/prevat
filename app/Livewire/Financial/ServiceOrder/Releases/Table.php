<?php

namespace App\Livewire\Financial\ServiceOrder\Releases;

use App\Models\ScheduleCompany;
use App\Models\ScheduleCompanyParticipants;
use App\Repositories\Financial\FinancialRepository;
use App\Repositories\Financial\ServiceOrderRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\ScheduleCompanyParticipantsRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;
    public $filters;
    public $releases = [];
    public $filterReleases = [];
    public $company_id;
    public $contract_id;
    public $orderService;

    public function mount($service_order_id, $id = null, $contract_id = null, $edit = null )
    {
        $serviceOrderRepository = new ServiceOrderRepository();
        $serviceOrderReturnDB = $serviceOrderRepository->show($service_order_id)['data'];

        if($serviceOrderReturnDB) {
            $this->orderService = $serviceOrderReturnDB;
        }

        $scheduleCompanyDB = ScheduleCompany::query()->where('company_id', $id)->pluck('id');
        $this->releases = $scheduleCompanyDB;

        $this->company_id = $id;
        $this->contract_id = $contract_id ?? $serviceOrderReturnDB['contract_id'];

    }

    #[On('filterTableReleases')]
    public function filterTableReleases($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterReleases')]
    public function clearFilterReleases($visible = null)
    {
        $this->filters = null;
    }
    public function addRelease($release_id = null)
    {
        $this->releases[] =+ $release_id;
        $this->dispatch('addRelease', release_id:$release_id);
    }

    public function addSelectionsRelease()
    {
        $this->dispatch('addSelectionsRelease', releases:$this->filterReleases->pluck('id'));
        $this->closeModal();
        $this->sendNotificationSuccess('Sucesso !', 'Lançamentos adicionados com sucesso.');
    }
    #[On('getReleases')]
    public function getReleases()
    {
        $financialRepository = new FinancialRepository();
        $financialRepositoryReturnDB =  $financialRepository->getReleasesByCompany($this->company_id, $this->contract_id, $this->releases, $this->filters);

        $this->filterReleases = $financialRepositoryReturnDB;
        return $financialRepositoryReturnDB;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->releases = $this->getReleases();

        return view('livewire.financial.service-order.releases.table', ['response' => $response]);
    }
}
