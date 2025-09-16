<?php

namespace App\Livewire\Manage\Contact;

use App\Repositories\Manage\ContactRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'type' => null,
    ];

    public $contact;

    public function mount($id = null)
    {
        $contactRepository = new ContactRepository();
        $contactReturnDB = $contactRepository->show($id)['data'];
        $this->contact = $contactReturnDB;

        if($this->contact){
            $this->state = $this->contact->toArray();
        }
    }

    public function save()
    {
        if($this->contact){
            return $this->update();
        }

        $request = $this->state;

        $contactRepository = new ContactRepository();
        $contactReturnDB = $contactRepository->create($request);

        if($contactReturnDB['status'] == 'success') {
            return redirect()->route('manage.contact')->with($contactReturnDB['status'], $contactReturnDB['message']);
        } else if ($contactReturnDB['status'] == 'error') {
            return redirect()->back()->with($contactReturnDB['status'], $contactReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $contactRepository = new ContactRepository();

        $contactReturnDB = $contactRepository->update($request, $this->contact->id);

        if($contactReturnDB['status'] == 'success') {
            return redirect()->route('manage.contact')->with($contactReturnDB['status'], $contactReturnDB['message']);
        } else if ($contactReturnDB['status'] == 'error') {
            return redirect()->back()->with($contactReturnDB['status'], $contactReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.manage.contact.form');
    }
}
