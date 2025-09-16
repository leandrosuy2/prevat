<?php

namespace App\Livewire\Manage\BlogCategories;

use App\Repositories\Site\BlogCategoriesRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    #[On('getBlogCategories')]
    public function getBlogCategories()
    {
        $blogCategoriesRepository = new BlogCategoriesRepository();
        $blogCategoriesReturnDB = $blogCategoriesRepository->index($this->order)['data'];

        return $blogCategoriesReturnDB;
    }

    #[On('confirmDeleteBlogCategory')]
    public function delete($id = null)
    {
        $blogCategoriesRepository = new BlogCategoriesRepository();
        $blogCategoriesReturnDB = $blogCategoriesRepository->delete($id);

        if($blogCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog-categories.blog')->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        } else if ($blogCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getBlogCategories();

        return view('livewire.manage.blog-categories.table', ['response' => $response]);
    }
}
