<div>
    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h2 class="page-header__title">Nossos Treinamentos</h2>
            @if($category)
                <h2 class="fs-22 text-white mb-1 text-uppercase" >{{$category['name']}}</h2>
            @endif
        </div>
    </section>
    <section class="course-two course-two--page">
        <div class="container">
        <div class="row">
            @forelse($response->trainings as $itemTraining)
                <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="course-two__item">
                        <div class="course-two__thumb">
                            @if($itemTraining['image'])
                                <img src="{{url('storage/'.$itemTraining['image'])}}" alt="treinamento" loading="lazy"  width="420" height="290" style=" width: 100%;  height: 280px">
                            @else
                                <img src="{{url('images/sem_foto.png')}}" alt="treinamento" loading="lazy"  width="420" height="280" style="width: 100%; height: 280px">
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 353 177">
                                <path d="M37 0C16.5655 0 0 16.5655 0 37V93.4816C0 103.547 4.00259 113.295 11.7361 119.737C54.2735 155.171 112.403 177 176.496 177C240.589 177 298.718 155.171 341.261 119.737C348.996 113.295 353 103.546 353 93.4795V37C353 16.5655 336.435 0 316 0H37Z" />
                            </svg>
                        </div>
                        <div class="course-two__content">
                            <div class="course-two__time">{{$itemTraining['time']}} {{ $itemTraining['type'] }}</div>
                            <div class="course-two__ratings">
                                <span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span>
                                <div class="course-two__ratings__reviews"></div>
                            </div>
                            <h3 class="course-two__title">
                                <a href="#"> {{$itemTraining['name']}}</a>
                            </h3>
        {{--                        <div class="course-two__bottom">--}}
        {{--                            <div class="course-two__author" style=" padding-right: 5px;">--}}
        {{--                                <img src="{{url('site/arquivos/author-2.png')}}" alt="Guilherme Schmitz" loading="lazy" width="50" height="50" style=" width: 100%; height: auto">--}}
        {{--                                <h5 class="course-two__author__name">Nome do Professor</h5>--}}
        {{--                                <p class="course-two__author__designation">Especialista</p>--}}
        {{--                            </div>--}}
        {{--                            <div class="course-two__meta" style=" min-width: 80px;">--}}
        {{--                                <h4 class="course-two__meta__price"> {{formatMoney($itemTraining['value'])}}</h4>--}}
        {{--                                <p class="course-two__meta__class"> {{$itemTraining['time']}} {{ $itemTraining['type'] }}</p>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
                            <div class="hero-banner__btn wow fadeInUp" data-wow-delay="600ms" style= "margin-top: 20px">
                                <a href="{{route('courses.view', $itemTraining['id'])}}" class="eduact-btn" style=" float: left; width: 100%;"><span class="eduact-btn__curve"></span>Saiba mais <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="section-title text-center">
                        <span class="section-title__tagline" style=" font-weight: bold">
                            Sinto muito.                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 133 13" fill="none">
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
                    <h2 class="section-title__title">Sem Treinamentos cadastrados para essa categoria</h2>
                </div>
            @endforelse
                <div class="">
                    {{ $response->trainings->links('site.pagination.site') }}
                </div>

        </div>
        </div>
    </section>

</div>
