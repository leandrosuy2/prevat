<?php

namespace App\Livewire\Site\Blog;

use App\Repositories\Site\BlogCategoriesRepository;
use App\Repositories\Site\BlogRepository;
use Livewire\Component;
use function Termwind\renderUsing;

class View extends Component
{
    public $post;

    public function mount($id = null)
    {
        $blogSiteRepository = new BlogRepository();
        $blogReturnDB = $blogSiteRepository->show($id);

        if($blogReturnDB) {
            $this->post = $blogReturnDB['data'];
        }
    }

    public function getLastFivePosts()
    {
        $blogRepository = new BlogRepository();
        return $blogRepository->getLastFivePosts();
    }

    public function getBlogCategories()
    {
        $blogRepository = new BlogRepository();
        return $blogRepository->getCategoriesBlogActive();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->lastPosts = $this->getLastFivePosts();
        $response->categories = $this->getBlogCategories();

        return view('livewire.site.blog.view', ['response' => $response]);
    }
}
