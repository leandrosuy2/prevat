<?php

namespace App\Livewire\Manage\Consultancy;

use App\Repositories\Manage\ConsultancyRepository;
use App\Trait\Interactions;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads, Interactions;

    public $state = [
        'status' => '',
    ];

    public $consultancy;
    public $image;

    public function mount($id = null)
    {
        $consultanciesRepository = new ConsultancyRepository();
        $consultanciesReturnDB = $consultanciesRepository->show($id)['data'];
        $this->consultancy = $consultanciesReturnDB;

        if($this->consultancy){
            $this->state = $this->consultancy->toArray();
        }
    }

    public function updatedImage()
    {
        if($this->image){
            $this->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->consultancy){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $consultanciesRepository = new ConsultancyRepository();
        $consultanciesReturnDB = $consultanciesRepository->create($request, $validatedImage['image']);

        if($consultanciesReturnDB['status'] == 'success') {
            return redirect()->route('manage.consultancy')->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        } else if ($consultanciesReturnDB['status'] == 'error') {
            return redirect()->back()->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $consultanciesRepository = new ConsultancyRepository();

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $consultanciesReturnDB = $consultanciesRepository->update($request, $this->consultancy->id, $validatedImage['image']);

        if($consultanciesReturnDB['status'] == 'success') {
            return redirect()->route('manage.consultancy')->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        } else if ($consultanciesReturnDB['status'] == 'error') {
            return redirect()->back()->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        }
    }
    public function removeImage($id = null)
    {
        $consultanciesRepository = new ConsultancyRepository();

        $consultanciesReturnDB = $consultanciesRepository->deleteImage($id);

        if($consultanciesReturnDB['status'] == 'success') {
            return redirect()->route('manage.consultancy.edit', $id)->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        } else if ($consultanciesReturnDB['status'] == 'error') {
            return redirect()->back()->with($consultanciesReturnDB['status'], $consultanciesReturnDB['message']);
        }
    }
    public function render()
    {
        return view('livewire.manage.consultancy.form');
    }
}
