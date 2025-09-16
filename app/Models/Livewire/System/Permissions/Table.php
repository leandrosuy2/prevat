<?php

namespace App\Livewire\System\Permissions;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getRoles')]
    public function getRoles()
    {
        $roleRepository = new RoleRepository();
        $roleReturnDB = $roleRepository->index($this->order)['data'];

        return $roleReturnDB;
    }

    #[On('confirmDeleteRole')]
    public function delete($id = null)
    {
        $roleRepository = new RoleRepository();
        $roleReturnDB = $roleRepository->delete($id);

        if($roleReturnDB['status'] == 'success') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        } else if ($roleReturnDB['status'] == 'error') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->roles = $this->getRoles();

        return view('livewire.system.permissions.table', ['response' => $response]);
    }
}
