<?php

namespace App\Livewire\Site\Auth;

use App\Http\Controllers\AuthController;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Site\SiteAuthRepository;
use Livewire\Component;

class Login extends Component
{
    public $state = [];
    public $error= '';

    public function submit()
    {
        $request = $this->state;

        $siteAuthRepository = new SiteAuthRepository();
        $userReturnDB = $siteAuthRepository->login($request);

        if($userReturnDB['status'] == 'success') {
            return redirect()->route('dashboard')->with('Bemvindo', 'OLá sega be, vindo ao sistema');
        } else if ($userReturnDB['status'] == 'error') {
            return $this->error =  $userReturnDB['message'];
        }
    }

    public function render()
    {
        return view('livewire.site.auth.login');
    }
}
