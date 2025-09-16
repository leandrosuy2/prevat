<?php

namespace App\Livewire\Movement\WithdrawalProtocol;

use App\Repositories\Movements\EvidenceRepository;
use App\Repositories\WithdrawalProtocolRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableWithDrawalProtocol')]
    public function filterTableWithDrawalProtocol($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getProtocols')]
    public function getProtocols()
    {
        $withdrawalProtocolRepository = new WithdrawalProtocolRepository();
        $withdrawalProtocolReturnDB = $withdrawalProtocolRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $withdrawalProtocolReturnDB;
    }

    #[On('confirmDeleteProtocol')]
    public function delete($id = null)
    {
        $withdrawalProtocolRepository = new WithdrawalProtocolRepository();
        $withdrawalProtocolReturnDB = $withdrawalProtocolRepository->delete($id);

        if($withdrawalProtocolReturnDB['status'] == 'success') {
            return redirect()->route('movement.withdrawal-protocol')->with($withdrawalProtocolReturnDB['status'], $withdrawalProtocolReturnDB['message']);
        } else if ($withdrawalProtocolReturnDB['status'] == 'error') {
            return redirect()->back()->with($withdrawalProtocolReturnDB['status'], $withdrawalProtocolReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->protocols = $this->getProtocols();

        return view('livewire.movement.withdrawal-protocol.table', ['response' => $response]);
    }
}
