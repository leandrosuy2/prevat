<?php

namespace App\Livewire\WorkSafety\Inspection;

use App\Repositories\WorkSafety\InspectionRepository;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSlide;

    public $order = [
        'column' => 'id',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableInspections')]
    public function filterTableInspections($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilterInspections')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }

    #[On('getInspections')]
    public function getInspections()
    {
        $inspectionRepository = new InspectionRepository();
        return $inspectionRepository->index($this->order, $this->filters, $this->pageSize)['data'];
    }

    #[On('confirmDeleteCompany')]
    public function delete($id = null)
    {
        $inspectionRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionRepository->delete($id);

        if($inspectionReturnDB['status'] == 'success') {
            return redirect()->route('registration.company')->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        } else if ($inspectionReturnDB['status'] == 'error') {
            return redirect()->route('registration.company')->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->inspections = $this->getInspections();

        return view('livewire.work-safety.inspection.table', ['response' => $response]);
    }
}
