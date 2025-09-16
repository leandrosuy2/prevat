<div>
    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">{{$post['title']}}</h1>
        </div>
    </section>
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__content">
                        <div class="blog-details__img">
                            @if($post['image'])
                                <img src="{{asset('storage/'.$post['image'])}}" alt="{{$post['title']}}">
                            @else
                                <img src="{{asset('images/sem_foto.png')}}" alt="Sem Imagem">
                            @endif
                        </div>
                        <div class="blog-details__meta">
                            <div class="blog-details__meta__cats">
                                <a href="blog/4/1">{{$post['category']['name']}}</a>
                            </div>
                            <div class="blog-details__meta__date"><i class="icon-clock"></i> {{formatCertificate($post['created_at'])}}</div>
                        </div>
                        <h3 class="blog-details__title">{{$post['title']}}</h3>
                        <p>{!! $post['content'] !!}</p>
                   </div>
                </div>
                <div class="col-xl-4 col-lg-5 wow fadeInRight" data-wow-delay="300ms">
                    <div class="sidebar">
                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">Últimas Postagens</h3>
                            <ul class="sidebar__post__list list-unstyled">
                                @foreach($response->lastPosts as $itemPost)
                                <li>
                                    <div class="sidebar__post__image">
                                        @if($itemPost['image'])
                                        <img src="{{url('storage/'.$itemPost['image'])}}" title="{{$itemPost['title']}}" alt="{{$itemPost['title']}}">
                                        @else
                                        <img src="{{url('images/sem_foto.png')}}" title="{{$itemPost['title']}}" alt="{{$itemPost['title']}}">
                                        @endif
                                    </div>
                                    <div class="sidebar__post__content">
                                        <span class="sidebar__post__content__meta"><i class="icon-clock"></i>{{formatDate($itemPost['created_at'])}}</span>
                                        <h3 class="sidebar__post__content__title"><a href="{{route('blog.view', $itemPost['id'])}}">{{$itemPost['title']}}</a></h3>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__single sidebar__category">
                            <h3 class="sidebar__title">Categorias</h3>
                            <ul class="sidebar__category-list list-unstyled">
                                @foreach($response->categories as $itemCategory)
                                    <li><a href="#">{{ $itemCategory['label'] }}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
