<div>
    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">{{$training['name']}}</h1>
        </div>
    </section>

    <section class="about-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="about-one__content" style=" padding-right: 20px"><!-- about content start-->
                        <div class="section-title">
                            <h2 class="section-title__title">Saiba mais sobre o curso</h2>
                        </div>
                        <p class="about-one__content__text"> {!! $training['description'] !!}</p>
                        <a href="{{route('login')}}" class="eduact-btn"><span class="eduact-btn__curve"></span>Quero garantir meu curso! <i class="icon-arrow"></i></a><!-- /.btn -->
                    </div><!-- about content end-->
                </div>
                <div class="col-xl-4">
                    <div class="about-one__thumb wow fadeInLeft" data-wow-delay="100ms" style=" margin-top: 120px">
                        @if($training['image'])
                            <img src="{{url('storage/'.$training['image'])}}" alt="Saiba mais sobre o curso" style=" width: 100%">
                        @else
                            <img src="{{url('images/sem_foto.png')}}" alt="Saiba mais sobre o curso" style=" width: 100%">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($response->images->count() > 0)
    <section class="about-one" style=" background: #40659C;">
        <div class="container">
            <div class="section-title text-center">
                    <span class="section-title__tagline" style=" font-weight: bold">
                        Imagens
                    </span>
                <h2 class="section-title__title text-white">Confira abaixo as imagens do nosso treinamento </h2>
            </div>
            <div class="row">

                <div class="category-one__slider eduact-owl__carousel owl-with-shadow owl-theme owl-carousel" data-owl-options='{
            "items": 4,
            "margin": 30,
            "smartSpeed": 700,
            "loop":true,
            "autoplay": true,
            "nav":false,
            "dots":true,
            "navText": ["<span class=\"icon-arrow-left\"></span>","<span class=\"icon-arrow\"></span>"],
            "responsive":{
                "0":{
                    "items":1,
                    "nav":true,
                    "dots":false,
                    "margin": 0
                },
                "670":{
                    "nav":true,
                    "dots":false,
                    "items": 2
                },
                "992":{
                    "items": 3
                },
                "1200":{
                    "items": 4
                },
                "1400":{
                    "items": 4,
                    "margin": 36
                }
            }
            }'>
                    @foreach($response->images as $itemImage)
                        <div class="item">
                            <div class="category-one__item">
                                <div class="category-one__wrapper">
                                    <div class="m-3">
                                        <img src="{{url('storage/'.$itemImage['path'])}}" alt="Hydro" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="cta-one mt-5 mb-5">
        <div class="cta-one__bg" style="background-image: url(../../site/arquivos/cta-bg-1.png);"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="cta-one__left">
                        @livewire('site.contact.card')
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 wow fadeInUp" data-wow-delay="400ms">

                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="cta-one__thumb__area wow fadeInUp" data-wow-delay="200ms">
                        <div class="cta-one__thumb eduact-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 4, "speed": 700, "scale": 1 }'>
                            <img src="{{url('site/arquivos/cta-2.png')}}" title="Nome do CTA" alt="Nome do CTA" loading="lazy" width="460" height="465" style=" max-width: 100%; height: auto">
                        </div>
                        <div class="cta-one__thumb__area__dark wow zoomIn" data-wow-delay="400ms"></div>
                        <svg viewBox="0 0 611 556" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M555.808 95.8321C526.054 35.589 468.004 11.1869 403.454 20.9135C289.531 38.072 13.8566 185.923 18.9328 335.709C21.1965 402.647 82.6767 445.989 139.184 473.388C225.719 515.342 328.597 544.419 425.405 534.761C459.035 531.405 494.157 521.884 520.961 500.461C549.566 477.6 565.052 440.218 575.067 406.004C587.157 364.666 592.748 319.184 591.976 276.168C590.913 217.123 582.27 149.38 555.808 95.8321Z" fill="url(#paint0_linear_268_9)" />
                            <path d="M387.299 555.447C286.444 555.447 192.226 520.034 130.952 490.324C46.183 449.226 2.16083 397.425 0.0857661 336.342C-5.4706 172.566 282.449 20.0916 400.642 2.28241C410.708 0.758347 420.758 0.00488281 430.498 0.00488281C493.419 0.00488281 545.261 31.8903 572.717 87.4927C596.624 135.886 609.451 199.263 610.823 275.825C611.646 322.078 605.541 368.913 593.159 411.278C584.053 442.427 567.881 487.07 532.742 515.154C506.35 536.234 470.868 549.146 427.274 553.478C414.292 554.797 400.847 555.447 387.299 555.447ZM387.299 552.023C400.744 552.023 414.069 551.372 426.949 550.087C469.873 545.806 504.755 533.152 530.616 512.483C565 484.998 580.915 441.006 589.884 410.319C602.18 368.279 608.234 321.804 607.41 275.894C606.039 199.828 593.348 136.965 569.665 89.0168C542.792 34.6301 492.082 3.42973 430.516 3.42973C420.946 3.42973 411.068 4.1832 401.173 5.67301C283.838 23.3452 -1.9893 174.278 3.49847 336.223C5.52209 395.935 48.9098 446.743 132.444 487.241C193.392 516.798 287.096 552.023 387.299 552.023Z" fill="url(#paint1_linear_268_9)" />
                            <path d="M563.097 141.554C549.446 79.3244 501.565 43.6716 439.948 37.9521C331.153 27.8317 43.6621 101.226 14.1824 240.258C1.01179 302.402 47.7093 356.275 93.4807 394.342C163.57 452.633 251.649 502.807 342.951 515.924C374.678 520.479 409.165 519.709 438.73 506.078C470.285 491.539 493.059 460.664 510.071 431.433C530.633 396.123 546.153 355.539 555.259 315.759C567.744 261.184 575.238 196.865 563.097 141.554Z" fill="url(#paint2_linear_268_9)" />
                            <defs>
                                <linearGradient id="paint0_linear_268_9" x1="137.156" y1="59.5939" x2="389.089" y2="514.127" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#99CC4D" />
                                    <stop offset="1" stop-color="white" stop-opacity="0" />
                                </linearGradient>
                                <linearGradient id="paint1_linear_268_9" x1="137.275" y1="26.0413" x2="435.685" y2="537.491" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#99CC4D" stop-opacity="0.71" />
                                    <stop offset="1" stop-color="white" stop-opacity="0" />
                                </linearGradient>
                                <linearGradient id="paint2_linear_268_9" x1="137.156" y1="59.5939" x2="389.089" y2="514.127" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#99CC4D" />
                                    <stop offset="1" stop-color="white" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="course-two" style=" background: #4B81BC; margin-bottom: -120px">
        <div class="container wow fadeInUp" data-wow-delay="200ms">
            <div class="section-title">
                <h2 class="section-title__title" style=" color: #FFF">Cursos Relacionados</h2>
            </div>
            <div class="course-two__slider eduact-owl__carousel owl-with-shadow owl-theme owl-carousel" data-owl-options='{
            "items": 3,
            "margin": 30,
            "smartSpeed": 700,
            "loop":true,
            "autoplay": true,
            "dots":false,
            "nav":true,
            "navText": ["<span class=\"icon-arrow-left\"></span>","<span class=\"icon-arrow\"></span>"],
            "responsive":{
                "0":{
                    "items":1
                },
                "768":{
                    "items": 2
                },
                "1200":{
                    "items": 3
                },
                "1400":{
                    "margin": 36,
                    "items": 3
                }
            }
            }'>

                @foreach($response->products as $itemTraining)
                <div class="item">
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
                            <div class="hero-banner__btn wow fadeInUp" data-wow-delay="600ms" style= "margin-top: 20px">
                                <a href="{{route('courses.view', $itemTraining['id'])}}" class="eduact-btn" style=" float: left; width: 100%;"><span class="eduact-btn__curve"></span>Saiba mais <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta-one-space"></section>
</div>
