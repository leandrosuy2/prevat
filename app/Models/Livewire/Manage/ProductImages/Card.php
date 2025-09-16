<?php

namespace App\Livewire\Manage\ProductImages;

use App\Repositories\Manage\ProductImageRepository;
use App\Repositories\Manage\ProductRepository;
use App\Trait\WithSlide;
use Livewire\Attributes\On;
use Livewire\Component;

class Card extends Component
{
    use WithSlide;

    public $product;

    public $order = [
        'column' => 'id',
        'order' => 'ASC'
    ];


    public function mount($id = null)
    {
        $productRepository = new ProductRepository();
        $productReturnDB = $productRepository->show($id);

        if($productReturnDB){
            $this->product = $productReturnDB['data'];
        }
    }
    #[On('getProductImages')]
    public function getImages()
    {
        $productImagesRepository = new ProductImageRepository();
        return $productImagesRepository->index($this->product->id, $this->order)['data'];
    }

    #[On('confirmDeleteImageProduct')]
    public function delete($id = null)
    {
        $productImagesRepository = new ProductImageRepository();
        $productReturnDB = $productImagesRepository->delete($id);

        if($productReturnDB['status'] == 'success') {
            return redirect()->route('manage.product.images', $this->product->id)->with($productReturnDB['status'], $productReturnDB['message']);
        } else if ($productReturnDB['status'] == 'error') {
            return redirect()->back()->with($productReturnDB['status'], $productReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->images = $this->getImages();

        return view('livewire.manage.product-images.card', ['response' => $response]);
    }
}
