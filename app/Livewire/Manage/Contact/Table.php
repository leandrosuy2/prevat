<?php

namespace App\Livewire\Manage\Contact;

use App\Repositories\Manage\ContactRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'id',
        'order' => 'asc'
    ];

    #[On('getContacts')]
    public function getContacts()
    {
        $contactRepository = new ContactRepository();
        $contactReturnDB = $contactRepository->index($this->order)['data'];

        return $contactReturnDB;
    }

    #[On('confirmDeleteContact')]
    public function delete($id = null)
    {
        $contactRepository = new ContactRepository();
        $contactReturnDB = $contactRepository->delete($id);

        if($contactReturnDB['status'] == 'success') {
            return redirect()->route('manage.contact')->with($contactReturnDB['status'], $contactReturnDB['message']);
        } else if ($contactReturnDB['status'] == 'error') {
            return redirect()->back()->with($contactReturnDB['status'], $contactReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contacts = $this->getContacts();

        return view('livewire.manage.contact.table', ['response' => $response]);
    }
}
