<?php

namespace App\Livewire\Manage\Blog;

use App\Repositories\Manage\BlogRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    #[On('getBlogs')]
    public function getBlogs()
    {
        $blogRepository = new BlogRepository();
        $blogReturnDB = $blogRepository->index($this->order)['data'];

        return $blogReturnDB;
    }

    #[On('confirmDeleteBlog')]
    public function delete($id = null)
    {
        $blogRepository = new BlogRepository();
        $blogReturnDB = $blogRepository->delete($id);

        if($blogReturnDB['status'] == 'success') {
            return redirect()->route('manage.blog')->with($blogReturnDB['status'], $blogReturnDB['message']);
        } else if ($blogReturnDB['status'] == 'error') {
            return redirect()->back()->with($blogReturnDB['status'], $blogReturnDB['message']);
        }
    }

    public function render()
    {
        $response = new \stdClass();
        $response->posts = $this->getBlogs();

        return view('livewire.manage.blog.table', ['response' => $response]);
    }
}
