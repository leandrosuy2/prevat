<?php

namespace App\Livewire\System\Permissions;

use App\Repositories\RoleRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $role;

    public $selected;

    public function mount($id = null)
    {
        $roleRepository = new RoleRepository();
        $roleReturnDB = $roleRepository->show($id)['data'];
        $this->role = $roleReturnDB;

        if($this->role){
            $this->state = $this->role->toArray();
        }
    }
    public function updatedSelected()
    {
        $this->state['status'] = $this->selected;
    }

    public function save()
    {
        if($this->role){
            return $this->update();
        }

        $request = $this->state;

        $roleRepository = new RoleRepository();
        $roleReturnDB = $roleRepository->create($request);

        if($roleReturnDB['status'] == 'success') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        } else if ($roleReturnDB['status'] == 'error') {
            return redirect()->back()->with($roleReturnDB['status'], $roleReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $roleRepository = new RoleRepository();

        $roleReturnDB = $roleRepository->update($request, $this->role->id);

        if($roleReturnDB['status'] == 'success') {
            return redirect()->route('permissions')->with($roleReturnDB['status'], $roleReturnDB['message']);
        } else if ($roleReturnDB['status'] == 'error') {
            return redirect()->back()->with($roleReturnDB['status'], $roleReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.system.permissions.form');
    }
}
