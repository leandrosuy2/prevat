<?php

namespace App\Livewire\Site\Contact;

use App\Repositories\Manage\ContactRepository;
use Livewire\Component;

class Card extends Component
{
    public $order = [
        'column' => 'id',
        'order' => 'asc'
    ];
    public function getContacts()
    {
        $contactRepository = new ContactRepository();
        return $contactRepository->index($this->order)['data'];
    }

    public function render()
    {
        $response = new \stdClass();
        $response->contacts = $this->getContacts();

        return view('livewire.site.contact.card', ['response' => $response]);
    }
}
