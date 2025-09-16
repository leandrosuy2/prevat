<?php

namespace App\Livewire\Site\Home;

use App\Repositories\Site\BlogRepository;
use Livewire\Component;

class Blog extends Component
{
    public function getLastPosts()
    {
        $blogRepository = new BlogRepository();
        return $blogRepository->getLastTreePosts();
    }

    public function render()
    {
        $response = new \stdClass();
        $response->posts = $this->getLastPosts();

        return view('livewire.site.home.blog', ['response' => $response]);
    }
}
