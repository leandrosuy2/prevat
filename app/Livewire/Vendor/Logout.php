<?php

namespace App\Livewire\Vendor;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        return $this->redirectRoute('login');

    }
    public function render()
    {
        return view('livewire.vendor.logout');
    }
}
