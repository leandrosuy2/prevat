<?php

namespace App\Livewire\Manage\Blog;

use App\Repositories\Manage\BlogRepository;
use App\Repositories\Site\BlogCategoriesRepository;
use App\Trait\Interactions;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads, Interactions;
    public $state = [
        'category_id' => null,
    ];
    public $blog;
    public $image;

    public function mount($id = null)
    {
        $blogRepository = new BlogRepository();
        $blogReturnDB = $blogRepository->show($id)['data'];
        $this->blog = $blogReturnDB;

        if($this->blog){
            $this->state = $this->blog->toArray();
        }
    }

    public function updatedImage()
    {
        if($this->image){
            $this->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
            ]);
        }
    }

    public function save()
    {
        if($this->blog){
            return $this->update();
        }

        $request = $this->state;

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $blogRepository = new BlogRepository();
        $blogReturnDB = $blogRepository->create($request, $validatedImage['image']);

        if($blogReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog')->with($blogReturnDB['status'], $blogReturnDB['message']);
        } else if ($blogReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogReturnDB['status'], $blogReturnDB['message']);
        }
    }

    public function update()
    {
        $request = $this->state;
        $blogRepository = new BlogRepository();

        $validatedImage = $this->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        $blogReturnDB = $blogRepository->update($request, $this->blog->id, $validatedImage['image']);

        if($blogReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog')->with($blogReturnDB['status'], $blogReturnDB['message']);
        } else if ($blogReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogReturnDB['status'], $blogReturnDB['message']);
        }
    }

    public function getSelectCategoriesBlog()
    {
        $blogCategoriesRepository = new BlogCategoriesRepository();
        return $blogCategoriesRepository->getSelectBlogCategories();
    }

    public function removeImage($id = null)
    {
        $blogRepository = new BlogRepository();

        $blogReturnDB = $blogRepository->deleteImage($id);

        if($blogReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog.edit', $id)->with($blogReturnDB['status'], $blogReturnDB['message']);
        } else if ($blogReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogReturnDB['status'], $blogReturnDB['message']);
        }

    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getSelectCategoriesBlog();

        return view('livewire.manage.blog.form', ['response' => $response]);
    }
}
