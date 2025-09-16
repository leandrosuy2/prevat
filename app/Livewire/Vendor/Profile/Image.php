<?php

namespace App\Livewire\Vendor\Profile;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;

    public $profile_photo_path;

    public function mount($id = null)
    {
        $userRepository = new UserRepository();
        $feesReturnDB = $userRepository->show(Auth::user()->id)['data'];
    }

    public function updateProfilePhotoPath()
    {
        $this->validate([
            'profile_photo_path' => 'image|max:1024',
        ]);
    }

    public function update()
    {
        $userRepository = new UserRepository();

        $profileReturnDB = $userRepository->uploadImage(Auth::user()->id, $this->profile_photo_path);

        if($profileReturnDB['status'] == 'success-image') {
            return redirect()->route('profile')->with($profileReturnDB['status'], $profileReturnDB['message']);
        } else if ($profileReturnDB['status'] == 'error') {
            return redirect()->back()->with($profileReturnDB['status'], $profileReturnDB['message']);
        }
    }
    public function render()
    {
        return view('livewire.vendor.profile.image');
    }
}
