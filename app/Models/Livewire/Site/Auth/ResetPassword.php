<?php

namespace App\Livewire\Site\Auth;

use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\Request;
use Livewire\Component;

class ResetPassword extends Component
{
    public $state = [];

    public function mount(Request $request)
    {
        if ($request){
            $this->state['email'] = $request->email;
            $this->state['token'] = $request->token;
        }
    }

    public function submit()
    {
        $request = $this->state;

        $authRepository = new AuthRepository();
        $authReturnDB = $authRepository->changePassword($request);

        if($authReturnDB['status'] == 'success') {
            return redirect()->route('login')->with($authReturnDB['status'], $authReturnDB['message']);
        } else if ($authReturnDB['status'] == 'error') {
            return redirect()->route('password.request')->with($authReturnDB['status'], $authReturnDB['message']);
        }

    }

    public function render()
    {
        return view('livewire.site.auth.reset-password');
    }
}
