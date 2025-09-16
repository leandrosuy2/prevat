<?php

namespace App\Livewire\Manage\ProductCategories;

use App\Repositories\Site\ProductCategoriesRepository;
use Livewire\Attributes\On;
use Livewire\Component;
class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getProductCategories')]
    public function getProductCategories()
    {
        $productCategoriesPepository = new ProductCategoriesRepository();
        $productCategoriesReturnDB = $productCategoriesPepository->index($this->order)['data'];

        return $productCategoriesReturnDB;
    }

    #[On('confirmDeleteProductCategory')]
    public function delete($id = null)
    {
        $productCategoriesPepository = new ProductCategoriesRepository();
        $productCategoriesReturnDB = $productCategoriesPepository->delete($id);

        if($productCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.product-categories.index')->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        } else if ($productCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getProductCategories();

        return view('livewire.manage.product-categories.table', ['response' => $response]);
    }
}
