<?php

namespace App\Livewire\Manage\BlogCategories;

use App\Repositories\Site\BlogCategoriesRepository;
use Livewire\Component;

class Form extends Component
{
    public $state = [
        'status' => '',
    ];

    public $category;

    public function mount($id = null)
    {
        $blogCategoriesRepository = new BlogCategoriesRepository();
        $blogCategoriesReturnDB = $blogCategoriesRepository->show($id)['data'];
        $this->category = $blogCategoriesReturnDB;

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

        $blogCategoriesRepository = new BlogCategoriesRepository();
        $blogCategoriesReturnDB = $blogCategoriesRepository->create($request);

        if($blogCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog-categories.blog')->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        } else if ($blogCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $blogCategoriesRepository = new BlogCategoriesRepository();

        $blogCategoriesReturnDB = $blogCategoriesRepository->update($request, $this->category->id);

        if($blogCategoriesReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog-categories.blog')->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        } else if ($blogCategoriesReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogCategoriesReturnDB['status'], $blogCategoriesReturnDB['message']);
        }
    }

    public function render()
    {
        return view('livewire.manage.blog-categories.form');
    }
}
