<?php

namespace App\Livewire\System\Users\Contracts;

use App\Repositories\UserContractsRepository;
use App\Repositories\UserRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    use WithSlide, Interactions;

    public $user;

    public $order = [
        'column' => 'id',
        'order' => 'DESC'
    ];

    public function mount($id = null)
    {
        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->show($id)['data'];

        if($userReturnDB) {
            $this->user = $userReturnDB;
        }
    }

    #[On('getContractsByUser')]
    public function getContractsByUser()
    {
        $userContractsRepository = new UserContractsRepository();
        return $userContractsRepository->index($this->user->id, $this->order)['data'];
    }

    #[On('confirmDeleteContractUser')]
    public function delete($id = null)
    {
        $userContractsRepository = new UserContractsRepository();
        $contractReturnDB = $userContractsRepository->delete($id);

        if($contractReturnDB['status'] == 'success') {
            return redirect()->route('users.contracts', $this->user->id)->with($contractReturnDB['status'], $contractReturnDB['message']);
        } else if ($contractReturnDB['status'] == 'error') {
            return redirect()->back()->with($contractReturnDB['status'], $contractReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contracts = $this->getContractsByUser();

        return view('livewire.system.users.contracts.table', ['response' => $response]);
    }
}
