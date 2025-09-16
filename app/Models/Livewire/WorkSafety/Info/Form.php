<?php

namespace App\Livewire\WorkSafety\Info;

use App\Models\SafetyItems;
use App\Repositories\WorkSafety\InspectionRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;

class Form extends Component
{
    use Interactions, WithSlide;

    public $state = [];
    public $info;
    public $item;
    public $key;

    public function mount($id = null, $key = null)
    {
        $safetyItemsDB = SafetyItems::query()->find($id);
        $this->item = $safetyItemsDB;

        $items = session()->get('items');
        $this->state = $items[$key];

        $this->key = $key;
    }

    public function save()
    {
        $request = $this->state;

        $inspectionsRepository = new InspectionRepository();
        $inspectionReturnDB = $inspectionsRepository->createInfo($request, $this->key);

        if($inspectionReturnDB['status'] == 'success') {
            $this->closeModal();
            $this->reset('state');
            $this->sendNotificationSuccess('Sucesso', $inspectionReturnDB['message']);
        } else if ($inspectionReturnDB['status'] == 'error') {
            return redirect()->back()->with($inspectionReturnDB['status'], $inspectionReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.work-safety.info.form');
    }
}
