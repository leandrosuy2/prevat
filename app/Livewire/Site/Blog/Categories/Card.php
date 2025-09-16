<?php

namespace App\Livewire\Site\Blog\Categories;

use App\Repositories\Site\BlogRepository;
use Livewire\Component;

class Card extends Component
{

    public function filterBlog($category_id)
    {
        $this->dispatch('filterCardBlog', filterData:$category_id);
    }
    public function getCategoriesBlog()
    {
        $blogRepository = new BlogRepository();
        return $blogRepository->getCategoriesBlogActive();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->categories = $this->getCategoriesBlog();

        return view('livewire.site.blog.categories.card', ['response' => $response]);
    }
}
