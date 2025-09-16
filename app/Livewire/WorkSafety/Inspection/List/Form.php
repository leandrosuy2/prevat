<?php

namespace App\Livewire\WorkSafety\Inspection\List;

use App\Models\WorkSafetyItems;
use App\Repositories\WorkSafety\InspectionRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use WithSlide, Interactions;

    public $state = [];
    public $item;
    public $info;


    public function mount($id = null, $key = null)
    {
        $safetyItemsDB = WorkSafetyItems::query()->with(['worksafety'])->find($id);
        $this->item = $safetyItemsDB;
        $this->info = $safetyItemsDB['worksafety'];
        $this->state = $this->item->toArray();
    }

    public function save()
    {
        $request = $this->state;

        $inspectionsRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionsRepository->updateInfo($request, $this->item->id);

        if($inspectionReturnDB['status'] == 'success') {
            $this->closeModal();
            $this->reset('state');
            $this->sendNotificationSuccess('Sucesso', $inspectionReturnDB['message']);
        } else if ($inspectionReturnDB['status'] == 'error') {
            $this->closeModal();
            $this->sendNotificationDanger('Sucesso', $inspectionReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.work-safety.inspection.list.form');
    }
}
