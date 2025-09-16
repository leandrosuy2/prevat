<?php

namespace App\Livewire\Manage\Product;

use App\Repositories\Manage\BlogRepository;
use App\Repositories\Manage\ProductRepository;
use App\Repositories\Site\ProductCategoriesRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $state = [
        'category_id' => '',
        'status' => '',
        'type' => ''
    ];

    public $product;

    public $image;

    public function mount($id = null)
    {
        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->show($id)['data'];
        $this->product = $productReturnDB;

        if($this->product){
            $this->state = $this->product->toArray();
        }
    }

    public function updatedImage()
    {
        if($this->image){
            $this->validate([
                'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->product){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->create($request, $validatedImage['image']);

        if($productReturnDB['status'] == 'success') {
            return redirect()->route('manage.product.index')->with($productReturnDB['status'], $productReturnDB['message']);
        } else if ($productReturnDB['status'] == 'error') {
            return redirect()->back()->with($productReturnDB['status'], $productReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->update($request, $this->product->id, $validatedImage['image']);

        if($productReturnDB['status'] == 'success') {
            return redirect()->route('manage.product.index')->with($productReturnDB['status'], $productReturnDB['message']);
        } else if ($productReturnDB['status'] == 'error') {
            return redirect()->back()->with($productReturnDB['status'], $productReturnDB['message']);
        }
    }

    public function removeImage($id = null)
    {
        $blogRepository = new ProductRepository();

        $blogReturnDB = $blogRepository->deleteImage($id);

        if($blogReturnDB['status'] == 'success') {
            return redirect()->route('manage.product.edit', $id)->with($blogReturnDB['status'], $blogReturnDB['message']);
        } else if ($blogReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogReturnDB['status'], $blogReturnDB['message']);
        }

    }

    public function getSelectCategoriesProduct()
    {
        $blogCategoriesRepository = new ProductCategoriesRepository();
        return $blogCategoriesRepository->getSelectProductCategories();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getSelectCategoriesProduct();

        return view('livewire.manage.product.form', ['response' => $response]);
    }
}
