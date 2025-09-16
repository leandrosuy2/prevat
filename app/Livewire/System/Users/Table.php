<?php

namespace App\Livewire\System\Users;

use App\Repositories\UserRepository;
use App\Trait\WithSlide;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSlide;

    public $order = [
        'column' => 'name',
        'order' => 'DESC'
    ];

    public $filters;

    public $pageSize = 15;

    #[On('filterTableUsers')]
    public function filterTableCompanies($filterData = null)
    {
        $this->filters = $filterData;
    }

    #[On('clearFilter')]
    public function clearFilter($visible = null)
    {
        $this->filters = null;
    }
    #[On('getUsers')]
    public function getUsers()
    {
        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $userReturnDB;
    }

    #[On('confirmDeleteUser')]
    public function delete($id = null)
    {
        $userRepository = new UserRepository();
        $userReturnDB = $userRepository->delete($id);

        if($userReturnDB['status'] == 'success') {
            if(Auth::user()->company->type == 'admin') {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            }else {
                return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
            }
        } else if ($userReturnDB['status'] == 'error') {
            return redirect()->route('users')->with($userReturnDB['status'], $userReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->users = $this->getUsers();

        return view('livewire.system.users.table', ['response' => $response]);
    }
}
