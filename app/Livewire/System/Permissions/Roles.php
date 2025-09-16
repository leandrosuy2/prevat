<?php

namespace App\Livewire\System\Permissions;

use App\Models\GroupPermissions;
use App\Repositories\RoleRepository;
use App\Repositories\RolesRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Roles extends Component
{

    public $permissions = [];

    public $role;

    public function mount($id = null)
    {
        $roleRepository = new RoleRepository();
        $roleReturnDB = $roleRepository->show($id)['data'];

        $this->permissions = $roleReturnDB['permissions']->pluck('name')->toArray();
        $this->role = $roleReturnDB;

    }

    public function submit()
    {
        $request = $this->permissions;
        $roleRepository = new RoleRepository();

        $roleReturnDB = $roleRepository->syncPermissions($this->role->id, $request);

        if($roleReturnDB['status'] == 'success') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        } else if ($roleReturnDB['status'] == 'error') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        }
    }

    public function getPermissions()
    {
        $groupPermissions = GroupPermissions::query()->with('permissions')->get();
        return $groupPermissions;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->permissions = $this->getPermissions();

        return view('livewire.system.permissions.roles', ['response' => $response]);
    }
}
