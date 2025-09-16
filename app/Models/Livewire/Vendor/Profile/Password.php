<?php

namespace App\Livewire\Vendor\Profile;

use App\Repositories\Auth\PasswordRepository;
use Livewire\Component;

class Password extends Component
{
    public $state = [];

    public function save()
    {
        $request = $this->state;

        $passwordRepository = new PasswordRepository();
        $passwordReturnDB = $passwordRepository->update($request);

        if($passwordReturnDB['status'] == 'password-updated') {
            return redirect()->route('profile')->with($passwordReturnDB['status'], $passwordReturnDB['message']);
        } else if ($passwordReturnDB['status'] == 'error') {
            return redirect()->back()->with($passwordReturnDB['status'], $passwordReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.vendor.profile.password');
    }
}
