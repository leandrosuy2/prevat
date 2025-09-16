<?php

namespace App\Livewire\Vendor\Profile;

use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Information extends Component
{
    public $state = [];
    public $profile;

    public function mount($id = null)
    {
        $profileRepository = new ProfileRepository();
        $profileReturnDB = $profileRepository->show(Auth::user()->id)['data'];
        $this->profile = $profileReturnDB;

        if($this->profile){
            $this->state = $this->profile->toArray();
        }
    }

    public function save()
    {
        $request = $this->state;

        $profileRepository = new ProfileRepository();
        $profileReturnDB = $profileRepository->update(Auth::user()->id, $request);

        if($profileReturnDB['status'] == 'profile-updated') {
            return redirect()->route('profile')->with($profileReturnDB['status'], $profileReturnDB['message']);
        } else if ($profileReturnDB['status'] == 'error') {
            return redirect()->back()->with($profileReturnDB['status'], $profileReturnDB['message']);
        }
    }
    public function render()
    {
        return view('livewire.vendor.profile.information');
    }
}
