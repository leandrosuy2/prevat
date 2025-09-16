<?php

namespace App\Livewire\System\Users;

use App\Repositories\CompanyContractRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [
        'status' => '',
        'notifications' => '',
        'contract_id' => '',
        'role_id' => null
    ];

    public $profile_photo_path;

    public $user;

    public function mount($id = null)
    {
        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->show($id)['data'];
        $this->user = $userReturnDB;

        if($this->user){
            $this->state = $this->user->toArray();
        }
    }
    public function updatedProfilePhotoPath()
    {
        if($this->profile_photo_path){
            $this->validate([
                'profile_photo_path' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->user){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'profile_photo_path' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->create($request, $validatedImage['profile_photo_path']);

        if($userReturnDB['status'] == 'success') {
            if(Auth::user()->company->type == 'admin') {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            } else {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            }
        } else if ($userReturnDB['status'] == 'error') {
            return redirect()->back()->with($userReturnDB['status'], $userReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $userRepository = new UserRepository();

        $validatedImage = $this->validate([
            'profile_photo_path' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $userReturnDB = $userRepository->update($request, $this->user->id, $validatedImage['profile_photo_path']);

        if($userReturnDB['status'] == 'success') {
            if(Auth::user()->company->type == 'admin') {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            } else {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            }
        } else if ($userReturnDB['status'] == 'error') {
            return redirect()->back()->with($userReturnDB['status'], $userReturnDB['message']);
        }
    }


    public function getSelectRoles()
    {
        $roleRepository = new RoleRepository();
        return $roleRepository->getSelectRoles();
    }

    public function getSelectContractsByCompany()
    {
        $companyContractsRepository = new CompanyContractRepository();
        return $companyContractsRepository->getSelectContracts(Auth::user()->company->id);
    }

    public function render()
    {
        $response = new \stdClass();
        $response->roles = $this->getSelectRoles();
        $response->contracts = $this->getSelectContractsByCompany();

        return view('livewire.system.users.form', ['response' => $response]);
    }
}
