<?php

namespace App\Livewire\Site\Auth;

use App\Repositories\Auth\AuthRepository;
use Livewire\Component;

class Recovery extends Component
{


    public $state = [];
    public $sent = false;

    public function submit()
    {
        $request = $this->state;
        $authRepository = new AuthRepository();
        $authReturnDB = $authRepository->passwordRecovery($request);

        if($authReturnDB['status'] == 'success') {
            $this->sent = true;
        } else if ($authReturnDB['status'] == 'error') {
            return redirect()->route('password.request')->with($authReturnDB['status'], $authReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.site.auth.recovery');
    }
}
