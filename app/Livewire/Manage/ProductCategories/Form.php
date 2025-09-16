<?php

namespace App\Livewire\Manage\ProductCategories;

use App\Repositories\Site\BlogCategoriesRepository;
use App\Repositories\Site\ProductCategoriesRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $category;

    public function mount($id = null)
    {
        $productCategoriesRepository = new BlogCategoriesRepository();
        $productCategoriesReturnDB = $productCategoriesRepository->show($id)['data'];
        $this->category = $productCategoriesReturnDB;

        if($this->category){
            $this->state = $this->category->toArray();
        }
    }

    public function save()
    {
        if($this->category){
            return $this->update();
        }

        $request = $this->state;

        $productCategoriesRepository = new ProductCategoriesRepository();
        $productCategoriesReturnDB = $productCategoriesRepository->create($request);

        if($productCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.product-categories.index')->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        } else if ($productCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $productCategoriesRepository = new ProductCategoriesRepository();

        $productCategoriesReturnDB = $productCategoriesRepository->update($request, $this->category->id);

        if($productCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.product-categories.index')->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        } else if ($productCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($productCategoriesReturnDB['status'], $productCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.manage.product-categories.form');
    }
}
