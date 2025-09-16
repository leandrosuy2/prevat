<?php

namespace App\Livewire\Manage\ProductImages;

use App\Repositories\Manage\ProductImageRepository;
use App\Repositories\Manage\ProductRepository;
use App\Trait\Interactions;
use App\Trait\WithSlide;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithSlide, Interactions, WithFileUploads;

    public $images;
    public $product;

    public function mount($id = null)
    {
        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->show($id);

        if($productReturnDB){
            $this->product = $productReturnDB['data'];
        }
    }

    public function save()
    {
        $validatedImage = $this->validate([
            'images' => ['required', 'array'],
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $productImageRepository = new ProductImageRepository();
        $productReturnDB = $productImageRepository->create($this->product->id, $validatedImage['images']);

        if($productReturnDB['status'] == 'success') {
            $this->dispatch('getProductImages');
            $this->closeModal();
            $this->sendNotificationSuccess('Sucesso', $productReturnDB['message']);
            $this->reset('images');
            return redirect()->back();
        } else if ($productReturnDB['status'] == 'error') {
            $this->sendNotificationDanger('Erro', $productReturnDB['message']);
            $this->closeModal();
        }
    }
    public function render()
    {
        return view('livewire.manage.product-images.form');
    }
}
