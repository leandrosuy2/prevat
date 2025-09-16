<?php

namespace App\Livewire\WorkSafety\Inspection\List;

use App\Models\SafetyCategories;
use App\Repositories\WorkSafety\InspectionRepository;
use App\Repositories\WorkSafety\InspectionsItemsRepository;
use App\Trait\WithSlide;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSlide;

    public $inspection;
    public $item_id;
    public $yes;
    public $not;
    public $na;

    public function mount($id = null)
    {
        $inspectionRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionRepository->show($id)['data'];

        if($inspectionReturnDB) {
            $this->inspection = $inspectionReturnDB;
        }
    }

    public function updatedYes($value, $key)
    {
        $inspectionsItemsRepository = new InspectionsItemsRepository();
        $inspectionsItemsRepository->validateYes($this->item_id[$key], $value);
    }

    public function updatedNot($value, $key)
    {
        $inspectionsItemsRepository = new InspectionsItemsRepository();
        $inspectionsItemsRepository->validateNot($this->item_id[$key], $value);
    }

    public function updatedNa($value, $key)
    {
        $inspectionsItemsRepository = new InspectionsItemsRepository();
        $inspectionsItemsRepository->validateNA($this->item_id[$key], $value);
    }

    public function getCategoryItems()
    {
        return SafetyCategories::query()->get();
    }
    public function getItemsByInspection()
    {
        $inspectionItemsRepository = new InspectionsItemsRepository();
        $inspectionReturnDB = $inspectionItemsRepository->index($this->inspection->id)['data'];

        foreach ($inspectionReturnDB as $key => $item) {
            $this->item_id[$key] = $item['id'];
            $this->yes[$key] = $item['yes'];
            $this->not[$key] = $item['not'];
            $this->na[$key] = $item['na'];
        }

        return $inspectionReturnDB;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getCategoryItems();
        $response->items = $this->getItemsByInspection();

        return view('livewire.work-safety.inspection.list.table', ['response' => $response]);
    }
}
