<?php

namespace App\Livewire\Manage\Informations;

use App\Repositories\Site\InfomationsRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [];

    public $information;

    public $logo;

    public function mount($id = null)
    {
        $informationsRepository = new InfomationsRepository();
        $informationsReturnDB = $informationsRepository->show($id)['data'];
        $this->information = $informationsReturnDB;

        if($this->information){
            $this->state = $this->information->toArray();
        }
    }

    public function updatedLogo()
    {
        if($this->logo){
            $this->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->information){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $informationsRepository = new InfomationsRepository();
        $informationsReturnDB = $informationsRepository->create($request, $validatedImage['logo']);

        if($informationsReturnDB['status'] == 'success') {
            return redirect()->route('manage.information')->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        } else if ($informationsReturnDB['status'] == 'error') {
            return redirect()->back()->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $validatedImage = $this->validate([
            'logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $informationsRepository = new InfomationsRepository();
        $informationsReturnDB = $informationsRepository->update($request, $this->information->id, $validatedImage['logo']);

        if($informationsReturnDB['status'] == 'success') {
            return redirect()->route('manage.information')->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        } else if ($informationsReturnDB['status'] == 'error') {
            return redirect()->back()->with($informationsReturnDB['status'], $informationsReturnDB['message']);
        }
    }


    public function render()
    {
        return view('livewire.manage.informations.form');
    }
}
