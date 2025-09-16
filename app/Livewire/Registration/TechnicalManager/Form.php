<?php

namespace App\Livewire\Registration\TechnicalManager;

use App\Models\TechnicalManager;
use App\Repositories\TechnicalManagerRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [
        'status' => '',
    ];

    public $signature_image;

    public $technical;

    public function mount($id = null)
    {
        $technicalManagerRepository = new TechnicalManagerRepository();
        $technicalManagerReturnDB = $technicalManagerRepository->show($id)['data'];
        $this->technical = $technicalManagerReturnDB;

        if($this->technical){
            $this->state = $this->technical->toArray();
        }
    }
    public function updatedSignatureImage()
    {
        if($this->signature_image){
            $this->validate([
                'signature_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->technical){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'signature_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $technicalManagerRepository = new TechnicalManagerRepository();
        $technicalManagerReturnDB = $technicalManagerRepository->create($request, $validatedImage['signature_image']);

        if($technicalManagerReturnDB['status'] == 'success') {
            return redirect()->route('registration.technical-manager')->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        } else if ($technicalManagerReturnDB['status'] == 'error') {
            return redirect()->back()->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;


        $validatedImage = $this->validate([
            'signature_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);
        $technicalManagerRepository = new TechnicalManagerRepository();
        $technicalManagerReturnDB = $technicalManagerRepository->update($request, $this->technical->id, $validatedImage['signature_image']);

        if($technicalManagerReturnDB['status'] == 'success') {
            return redirect()->route('registration.technical-manager')->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        } else if ($technicalManagerReturnDB['status'] == 'error') {
            return redirect()->back()->with($technicalManagerReturnDB['status'], $technicalManagerReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.registration.technical-manager.form');
    }
}
