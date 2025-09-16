<?php

namespace App\Livewire\Site\Blog;

use App\Repositories\Site\BlogRepository;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Card extends Component
{
    use WithPagination;

    public $order = [
        'column' => 'created_at',
        'order' => 'DESC'
    ];

    public $pageSize = 6;
    public $filters;
    #[On('filterCardBlog')]
    public function filterCardBlog($filterData = null)
    {
        $this->filters = $filterData;
    }
    #[On('getBlogs')]
    public function getBlogs()
    {
        $blogRepository = new BlogRepository();
        $blogReturnDB = $blogRepository->index($this->order, $this->filters, $this->pageSize)['data'];

        return $blogReturnDB;
    }

    public function render()
    {
        $response = new \stdClass();
        $response->posts = $this->getBlogs();

        return view('livewire.site.blog.card', ['response' => $response]);
    }
}
