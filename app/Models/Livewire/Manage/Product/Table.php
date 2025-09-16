<?php

namespace App\Livewire\Manage\Product;

use App\Repositories\Manage\ProductRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getProducts')]
    public function getProducts()
    {
        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->index($this->order)['data'];

        return $productReturnDB;
    }

    #[On('confirmDeleteProduct')]
    public function delete($id = null)
    {
        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->delete($id);

        if($productReturnDB['status'] == 'success') {
            return redirect()->route('manage.product.index')->with($productReturnDB['status'], $productReturnDB['message']);
        } else if ($productReturnDB['status'] == 'error') {
            return redirect()->back()->with($productReturnDB['status'], $productReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->products = $this->getProducts();

        return view('livewire.manage.product.table', ['response' => $response]);
    }
}
