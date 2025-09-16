<div>
    @if($response->posts->count() > 0)
    <section class="blog-three" style="background-image: url(site/assets/images/shapes/blog-bg-3.webp);">
    <div class="container">
        <div class="section-title text-center wow fadeInUp" data-wow-delay="100ms">
                    <span class="section-title__tagline">
                        Blog                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 133 13" fill="none">
                            <path d="M9.76794 0.395L0.391789 9.72833C-0.130596 10.2483 -0.130596 11.095 0.391789 11.615C0.914174 12.135 1.76472 12.135 2.28711 11.615L11.6633 2.28167C12.1856 1.76167 12.1856 0.915 11.6633 0.395C11.1342 -0.131667 10.2903 -0.131667 9.76794 0.395Z" fill="#F1F4FA" />
                            <path d="M23.1625 0.395L13.7863 9.72833C13.2639 10.2483 13.2639 11.095 13.7863 11.615C14.3087 12.135 15.1593 12.135 15.6816 11.615L25.0578 2.28167C25.5802 1.76167 25.5802 0.915 25.0578 0.395C24.5287 -0.131667 23.6849 -0.131667 23.1625 0.395Z" fill="#F1F4FA" />
                            <path d="M36.5569 0.395L27.1807 9.72833C26.6583 10.2483 26.6583 11.095 27.1807 11.615C27.7031 12.135 28.5537 12.135 29.076 11.615L38.4522 2.28167C38.9746 1.76167 38.9746 0.915 38.4522 0.395C37.9231 -0.131667 37.0793 -0.131667 36.5569 0.395Z" fill="#F1F4FA" />
                            <path d="M49.9514 0.395L40.5753 9.72833C40.0529 10.2483 40.0529 11.095 40.5753 11.615C41.0976 12.135 41.9482 12.135 42.4706 11.615L51.8467 2.28167C52.3691 1.76167 52.3691 0.915 51.8467 0.395C51.3176 -0.131667 50.4738 -0.131667 49.9514 0.395Z" fill="#F1F4FA" />
                            <path d="M63.3459 0.395L53.9698 9.72833C53.4474 10.2483 53.4474 11.095 53.9698 11.615C54.4922 12.135 55.3427 12.135 55.8651 11.615L65.2413 2.28167C65.7636 1.76167 65.7636 0.915 65.2413 0.395C64.7122 -0.131667 63.8683 -0.131667 63.3459 0.395Z" fill="#F1F4FA" />
                            <path d="M76.7405 0.395L67.3643 9.72833C66.8419 10.2483 66.8419 11.095 67.3643 11.615C67.8867 12.135 68.7373 12.135 69.2596 11.615L78.6358 2.28167C79.1582 1.76167 79.1582 0.915 78.6358 0.395C78.1067 -0.131667 77.2629 -0.131667 76.7405 0.395Z" fill="#F1F4FA" />
                            <path d="M90.1349 0.395L80.7587 9.72833C80.2363 10.2483 80.2363 11.095 80.7587 11.615C81.2811 12.135 82.1317 12.135 82.6541 11.615L92.0302 2.28167C92.5526 1.76167 92.5526 0.915 92.0302 0.395C91.5011 -0.131667 90.6573 -0.131667 90.1349 0.395Z" fill="#F1F4FA" />
                            <path d="M103.529 0.395L94.1533 9.72833C93.6309 10.2483 93.6309 11.095 94.1533 11.615C94.6756 12.135 95.5262 12.135 96.0486 11.615L105.425 2.28167C105.947 1.76167 105.947 0.915 105.425 0.395C104.896 -0.131667 104.052 -0.131667 103.529 0.395Z" fill="#F1F4FA" />
                            <path d="M116.924 0.395L107.548 9.72833C107.025 10.2483 107.025 11.095 107.548 11.615C108.07 12.135 108.921 12.135 109.443 11.615L118.819 2.28167C119.342 1.76167 119.342 0.915 118.819 0.395C118.29 -0.131667 117.446 -0.131667 116.924 0.395Z" fill="#F1F4FA" />
                            <path d="M130.318 0.395L120.942 9.72833C120.42 10.2483 120.42 11.095 120.942 11.615C121.465 12.135 122.315 12.135 122.838 11.615L132.214 2.28167C132.736 1.76167 132.736 0.915 132.214 0.395C131.685 -0.131667 130.841 -0.131667 130.318 0.395Z" fill="#F1F4FA" />
                        </svg>
                    </span>
            <h2 class="section-title__title">Últimas Postagens</h2>
        </div>
        <div class="row">

            @foreach($response->posts as $itemPost)
                <div class="col-xl-4 col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="blog-three__item">
                        <div class="blog-three__image">
                            @if($itemPost['image'] == null )
                                <img src="{{asset('images/sem_foto.png')}}" title="{{$itemPost['title']}}" alt="{{$itemPost['title']}}" style="height: 307px;">
                            @else
                                <img src="{{asset('storage/'.$itemPost['image'])}}" title="{{$itemPost['title']}}" alt="{{$itemPost['title']}}" style="height: 307px;">
                            @endif
                        </div>
                        <div class="blog-three__content">
                            <div class="blog-three__top-meta">
                                <div class="blog-three__cats"><a href="blog/4/1">{{$itemPost['category']['name']}}</a></div>
                                <div class="blog-three__date"> {{formatCertificate($itemPost['created_at'])}} </div>
                            </div>
                            <h3 class="blog-three__title">
                                <a href="{{route('blog.view',$itemPost['id'])}}"> {{$itemPost['title']}}</a>
                            </h3>
                            <p style=" margin-top: -5px; height:80px;"> {{ mb_strimwidth($itemPost['content'], 0 ,150, ' ...' )}} </p>
                            <div class="blog-three__meta">
                                <a href="{{route('blog.view', $itemPost['id'])}}" style=" font-weight: bold;">Leia mais</a>
                                <a class="blog-three__rm" href="{{route('blog.view', $itemPost['id'])}}"><span class="icon-arrow"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>
    @endif
</div>
