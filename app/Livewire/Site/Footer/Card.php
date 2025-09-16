<?php

namespace App\Livewire\Site\Footer;

use App\Repositories\Manage\ProductRepository;
use App\Repositories\Site\InfomationsRepository;
use Livewire\Component;

class Card extends Component
{
    public $information;

    public function mount()
    {
        $informationRepository = new InfomationsRepository();
        $informationReturnDB = $informationRepository->getFirst()['data'];

        if($informationReturnDB){
            $this->information = $informationReturnDB;
        }
    }

    public function getProducts()
    {
        $productRepository = new ProductRepository();
        return $productRepository->getSixProductsRandom();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getProducts();

        return view('livewire.site.footer.card', ['response' => $response]);
    }
}
