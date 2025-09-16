<?php
namespace App\Livewire\Site\Auth;

use App\Repositories\Site\SiteAuthRepository;
use Livewire\Component;

class Login extends Component
{
    public $state = [
        'email' => '',
        'password' => '',
    ];
    public $error = '';

    public function submit()
    {
        $this->validate([
            'state.email' => 'required|email',
            'state.password' => 'required|min:6',
        ]);

        $siteAuthRepository = new SiteAuthRepository();
        $userReturnDB = $siteAuthRepository->login($this->state);

        if ($userReturnDB['status'] === 'success') {
            return redirect()->route('dashboard')->with('Bemvindo', 'Olá, seja bem-vindo ao sistema');
        }

       
        $this->error = $userReturnDB['message'] ?? 'Erro ao tentar fazer login.';
    }

    public function render()
    {
        return view('livewire.site.auth.login');
    }
}

