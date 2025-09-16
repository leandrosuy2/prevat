@extends('site.layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero-banner" style="background-image: url(site/assets/images/shapes/banner-bg-1.webp);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-banner__content">
                        <div class="hero-banner__bg-shape1 wow zoomIn" data-wow-delay="300ms">
                            <div class="hero-banner__bg-round">
                                <div class="hero-banner__bg-round-border"></div>
                            </div>
                        </div>
                        <h2 class="hero-banner__title wow fadeInUp" data-wow-delay="400ms">Conheça a Prevat Treinamentos</h2>
                        <p class="hero-banner__text wow fadeInUp" data-wow-delay="500ms">
                            Bem-vindo à PREVAT TREINAMENTOS, uma instituição de destaque no mercado, reconhecida como referência em soluções de treinamento e desenvolvimento profissional. Com uma trajetória sólida e compromisso com a excelência, oferecemos treinamentos personalizados que capacitam indivíduos e empresas a alcançarem seus objetivos com eficácia. Nossa expertise nos posiciona como líderes no setor, garantindo que cada solução seja ajustada às necessidades específicas de nossos clientes.
                        </p>
                        <div class="hero-banner__btn wow fadeInUp" data-wow-delay="600ms">
                            <a href="{{route('contact')}}" class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Entre em contato<i class="icon-arrow"></i></a>
                            <a href="#" class="eduact-btn"><span class="eduact-btn__curve"></span>Treinamentos<i class="icon-arrow"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-banner__thumb wow fadeInUp" data-wow-delay="700ms">
                        <img src="{{url('site/assets/images/resources/banner-1-2.png')}}" alt="eduact">
                        <div class="hero-banner__cap wow slideInDown" data-wow-delay="800ms"><img src="{{url('site/assets/images/shapes/banner-cap.png')}}" alt="eduact"></div><!-- banner-cap -->
                        <div class="hero-banner__star wow slideInDown" data-wow-delay="850ms"><img src="{{url('site/assets/images/shapes/banner-star.png')}}" alt="eduact"></div><!-- banner-star -->
                        <div class="hero-banner__map wow slideInDown" data-wow-delay="900ms"><img src="{{url('site/assets/images/shapes/banner-map.png')}}" alt="eduact"></div><!-- banner-map -->
                        <div class="hero-banner__book wow slideInUp" data-wow-delay="1000ms"><img src="{{url('site/assets/images/shapes/banner-book.png')}}" alt="eduact"></div><!-- banner-book -->
                        <div class="hero-banner__star2 wow slideInUp" data-wow-delay="1050ms"><img src="{{url('site/assets/images/shapes/banner-star2.png')}}" alt="eduact"></div><!-- banner-star -->
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-banner__border wow fadeInUp" data-wow-delay="1100ms"></div>
    </section>
    <section class="about-three" style=" background: #F8F8FF">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="about-three__content"><!-- about content start-->
                        <div class="section-title">
                            <h5 class="section-title__tagline">
                                Sobre Nós
                                <svg class="arrow-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55 13">
                                    <g clip-path="url(#clip0_324_36194)">
                                        <path d="M10.5406 6.49995L0.700562 12.1799V8.56995L4.29056 6.49995L0.700562 4.42995V0.819946L10.5406 6.49995Z" />
                                        <path d="M25.1706 6.49995L15.3306 12.1799V8.56995L18.9206 6.49995L15.3306 4.42995V0.819946L25.1706 6.49995Z" />
                                        <path d="M39.7906 6.49995L29.9506 12.1799V8.56995L33.5406 6.49995L29.9506 4.42995V0.819946L39.7906 6.49995Z" />
                                        <path d="M54.4206 6.49995L44.5806 12.1799V8.56995L48.1706 6.49995L44.5806 4.42995V0.819946L54.4206 6.49995Z" />
                                    </g>
                                </svg>
                            </h5>
                            <h2 class="section-title__title">Um pouco sobre a PrevAT</h2>
                        </div>
                        <p>
                            A PREVAT TREINAMENTOS, fundada em 2014 sob a direção de Fernando Monteiro Santos, Formado na área de segurança do trabalho há mais de 20 anos de experiência .Construindo assim uma empresa especializada na capacitação em segurança do trabalho onde seu objetivo é proporcionar treinamentos que visam prevenir acidentes e promover a segurança dos colaboradores no ambiente de trabalho. Através de um centro de treinamento dedicado, a PREVAT se compromete a oferecer uma formação de qualidade, contribuindo para a saúde e segurança dos profissionais em suas atividades diárias.
                        </p>

                        <a href="{{route('about')}}" class="eduact-btn"><span class="eduact-btn__curve"></span>Saiba mais<i class="icon-arrow"></i></a>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="100ms">
                    <div class="about-three__thumb">
                        <div class="about-three__thumb__one eduact-tilt" data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                            <img src="{{url('site/assets/images/resources/about-4-1.jpg')}}" alt="eduact">
                        </div>
                        <div class="about-three__thumb__shape-one"></div>
                        <div class="about-three__thumb__shape-two"></div>
                        <div class="about-three__thumb__shape-three"><span></span><span></span><span></span><span></span><span></span></div>
                        <div class="about-three__thumb__shape-four"><img src="{{url('site/assets/images/shapes/about-3-shape-1.png')}}" alt="eduact" /></div>
                        <div class="about-three__thumb__shape-five"><span></span><span></span><span></span><span></span><span></span></div>
                        <div class="about-three__thumb__shape-six"><span></span><span></span><span></span><span></span><span></span></div>
                        <div class="about-three__thumb__shape-seven"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="category-one" style="background-image: url(site/midias/imagens/category-bg-1Resultado.17089795311.webp);">
        <div class="container">
            <div class="section-title text-center">
                    <span class="section-title__tagline" style=" font-weight: bold">
                        Nossos parceiros
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 133 13" fill="none">
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
                <h2 class="section-title__title">Confira abaixo nossos parceiros</h2>
            </div>
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
                    "items": 6
                },
                "1400":{
                    "items": 8,
                    "margin": 36
                }
            }
            }'>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro01.png')}}" alt="Hydro" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                            </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro02.png')}}" alt="02" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro03.jpg')}}" alt="03" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro04.png')}}" alt="03" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro05.png')}}" alt="03" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro06.png')}}" alt="03" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro07.png')}}" alt="03" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro08.png')}}" alt="08" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro09.png')}}" alt="09" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro10.png')}}" alt="10" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro11.png')}}" alt="11" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro12.png')}}" alt="12" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro13.png')}}" alt="13" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro14.png')}}" alt="14" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro15.png')}}" alt="15" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

{{--                <div class="item">--}}
{{--                    <div class="category-one__item">--}}
{{--                        <div class="category-one__wrapper">--}}
{{--                            <div class="m-3">--}}
{{--                                <img src="{{url('site/midias/parceiros/parceiro16.png')}}" alt="16" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro17.png')}}" alt="17" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro18.png')}}" alt="18" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro19.png')}}" alt="19" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro20.png')}}" alt="20" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro21.png')}}" alt="21" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro22.png')}}" alt="22" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro23.png')}}" alt="23" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro24.png')}}" alt="24" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro25.png')}}" alt="25" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro26.png')}}" alt="26" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro27.png')}}" alt="27" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="category-one__item">
                        <div class="category-one__wrapper">
                            <div class="m-3">
                                <img src="{{url('site/midias/parceiros/parceiro28.png')}}" alt="18" loading="lazy" width="300" height="335" style="width: 100%; height: auto" /></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <section class="cta-one">
        <div class="cta-one__bg" style="background-image: url(site/arquivos/cta-bg-1.png);"></div>
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

    <section class="team-one" style="background-image: url(site/midias/imagens/team-bg-1Resultado.17089795671.webp);">
        <div class="container">
            <div class="section-title text-center wow fadeInUp" data-wow-delay="100ms" style=" font-weight: bold">
                    <span class="section-title__tagline">
                        Nossa Equipe                        <svg viewBox="0 0 170 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.4101 0.395L1.034 9.72833C0.511616 10.2483 0.511616 11.095 1.034 11.615C1.55639 12.135 2.40694 12.135 2.92932 11.615L12.3055 2.28167C12.8279 1.76167 12.8279 0.915 12.3055 0.395C11.7764 -0.131667 10.9325 -0.131667 10.4101 0.395Z" fill="white" />
                            <path d="M23.4652 0.395L14.0891 9.72833C13.5667 10.2483 13.5667 11.095 14.0891 11.615C14.6114 12.135 15.462 12.135 15.9844 11.615L25.3605 2.28167C25.8829 1.76167 25.8829 0.915 25.3605 0.395C24.8314 -0.131667 23.9876 -0.131667 23.4652 0.395Z" fill="white" />
                            <path d="M36.5203 0.395L27.1441 9.72833C26.6217 10.2483 26.6217 11.095 27.1441 11.615C27.6665 12.135 28.517 12.135 29.0394 11.615L38.4156 2.28167C38.938 1.76167 38.938 0.915 38.4156 0.395C37.8865 -0.131667 37.0426 -0.131667 36.5203 0.395Z" fill="white" />
                            <path d="M49.5753 0.395L40.1992 9.72833C39.6768 10.2483 39.6768 11.095 40.1992 11.615C40.7215 12.135 41.5721 12.135 42.0945 11.615L51.4706 2.28167C51.993 1.76167 51.993 0.915 51.4706 0.395C50.9415 -0.131667 50.0977 -0.131667 49.5753 0.395Z" fill="white" />
                            <path d="M62.6304 0.395L53.2542 9.72833C52.7318 10.2483 52.7318 11.095 53.2542 11.615C53.7766 12.135 54.6272 12.135 55.1495 11.615L64.5257 2.28167C65.0481 1.76167 65.0481 0.915 64.5257 0.395C63.9966 -0.131667 63.1527 -0.131667 62.6304 0.395Z" fill="white" />
                            <path d="M75.6854 0.395L66.3093 9.72833C65.7869 10.2483 65.7869 11.095 66.3093 11.615C66.8317 12.135 67.6822 12.135 68.2046 11.615L77.5807 2.28167C78.1031 1.76167 78.1031 0.915 77.5807 0.395C77.0517 -0.131667 76.2078 -0.131667 75.6854 0.395Z" fill="white" />
                            <path d="M88.7405 0.395L79.3643 9.72833C78.8419 10.2483 78.8419 11.095 79.3643 11.615C79.8867 12.135 80.7373 12.135 81.2596 11.615L90.6358 2.28167C91.1582 1.76167 91.1582 0.915 90.6358 0.395C90.1067 -0.131667 89.2629 -0.131667 88.7405 0.395Z" fill="white" />
                            <path d="M101.796 0.395L92.4194 9.72833C91.897 10.2483 91.897 11.095 92.4194 11.615C92.9418 12.135 93.7923 12.135 94.3147 11.615L103.691 2.28167C104.213 1.76167 104.213 0.915 103.691 0.395C103.162 -0.131667 102.318 -0.131667 101.796 0.395Z" fill="white" />
                            <path d="M114.85 0.395L105.474 9.72833C104.952 10.2483 104.952 11.095 105.474 11.615C105.997 12.135 106.847 12.135 107.37 11.615L116.746 2.28167C117.268 1.76167 117.268 0.915 116.746 0.395C116.217 -0.131667 115.373 -0.131667 114.85 0.395Z" fill="white" />
                            <path d="M127.906 0.395L118.529 9.72833C118.007 10.2483 118.007 11.095 118.529 11.615C119.052 12.135 119.902 12.135 120.425 11.615L129.801 2.28167C130.323 1.76167 130.323 0.915 129.801 0.395C129.272 -0.131667 128.428 -0.131667 127.906 0.395Z" fill="white" />
                            <path d="M140.961 0.395L131.584 9.72833C131.062 10.2483 131.062 11.095 131.584 11.615C132.107 12.135 132.957 12.135 133.48 11.615L142.856 2.28167C143.378 1.76167 143.378 0.915 142.856 0.395C142.327 -0.131667 141.483 -0.131667 140.961 0.395Z" fill="white" />
                            <path d="M154.016 0.395L144.639 9.72833C144.117 10.2483 144.117 11.095 144.639 11.615C145.162 12.135 146.012 12.135 146.535 11.615L155.911 2.28167C156.433 1.76167 156.433 0.915 155.911 0.395C155.382 -0.131667 154.538 -0.131667 154.016 0.395Z" fill="white" />
                            <path d="M167.071 0.395L157.695 9.72833C157.172 10.2483 157.172 11.095 157.695 11.615C158.217 12.135 159.067 12.135 159.59 11.615L168.966 2.28167C169.488 1.76167 169.488 0.915 168.966 0.395C168.437 -0.131667 167.593 -0.131667 167.071 0.395Z" fill="white" />
                        </svg>
                    </span>
                <h2 class="section-title__title">Conheça os nossos especialistas</h2>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_roni.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h1 class="team-one__title">Roni Lobato</h1>
                            <span class="team-one__designation">Técnico em segurança do trabalho,
                            Bombeiro profissional civil e
                            Enfermeiro</span>

                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_gabriel.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h1 class="team-one__title">Gabriel Veloso Miranda</h1>
                            <span class="team-one__designation">Técnico em segurança do trabalho e
                                Especialista em máquinas e equipamentos
                            </span>

                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_orlando.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h1 class="team-one__title">Orlando Ferreira </h1>
                            <span class="team-one__designation">Técnico em segurança do trabalho e
Especialista máquinas e equipamentos</span>

                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_ezequiel.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h3 class="team-one__title">Ezequiel Assunção</h3>
                            <span class="team-one__designation">Técnico em segurança do trabalho,
                                Pedagogo,
                                Especialista em máquinas e equipamentos e
                                Especialista em trânsito
                            </span>
                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_flavio.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h3 class="team-one__title">Flávio da Silva</h3>
                            <span class="team-one__designation">Técnico em segurança do trabalho</span>
                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="team-one__item">
                        <div class="team-one__image">
                            <img src="{{url('site/midias/tecnicos/tec_ricardo.jpeg')}}" alt="Nome do Professor" loading="lazy" width="410" height="265" style="max-width: 100%; height: auto;" >
                        </div>
                        <div class="team-one__content">
                            <h4 class="team-one__title fs-15">Ricardo Dourado</h4>
                            <span class="team-one__designation">Técnico em segurança e Técnico em Eletrotécnica</span>
                            <div class="team-one__social">
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-two">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__thumb wow fadeInLeft" data-wow-delay="100ms">
                        <img src="{{url('site/midias/about/about_01.jpeg')}}" title="Titulo da Imagem" alt="Titulo da Imagem" loading="lazy" style=" width: 100%">
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="100ms">
                    <div class="about-two__content">
                        <div class="section-title" style=" margin-top: -40px">
                            <h2 class="section-title__title">Conheça nossos diferenciais</h2>
                        </div>
{{--                        <p class="about-two__content__text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed iaculis dui. Ut suscipit leo ut sagittis ornare. Suspendisse nec eleifend tellus, nec pellentesque enim. Nulla massa enim, aliquam in accumsan vitae, ornare eget nisi.</p>--}}
                        <div class="about-two__box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 295 125">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M86 0.0805664H58C25.9675 0.0805664 0 26.048 0 58.0806V79.5806C0 104.157 19.9233 124.081 44.5 124.081H46.5C69.9721 124.081 89 105.053 89 81.5806C89 58.1085 108.028 39.0806 131.5 39.0806H268C282.912 39.0806 295 26.9923 295 12.0806C295 5.45315 289.627 0.0805664 283 0.0805664H89H86Z" />
                            </svg>
                            <div class="about-two__box__icon"><span class="icon-Presentation"></span></div>
                            <h4 class="about-two__box__title">Cursos dinâmicos</h4>
                            <p class="about-two__box__text">Esses diferenciais ajudam a PREVAT a se destacar no mercado e a proporcionar um serviço de excelência aos seus clientes. Se precisar de mais detalhes ou tiver outras perguntas, estou aqui para ajudar!</p>
                        </div>
{{--                        <div class="">--}}
                        <div class="container">
                            <ul class="about-two__lists clearfix">
                                <div class="row">
                                    <li class="text-nowrap"><span class="icon-check"></span>Experiência e Expertise</li>
                                    <p class="">Com mais de 20 anos de atuação na área de segurança do trabalho, a equipe da PREVAT possui um conhecimento profundo e atualizado sobre as melhores práticas e normativas.</p>
{{--                                </div>--}}
{{--                                <div class="row">--}}
                                    <li class="text-nowrap"><span class="icon-check"></span>Capacitação Personalizada</li>
                                    <p class="">
                                        Oferecemos treinamentos adaptados às necessidades específicas de cada cliente, garantindo que os colaboradores recebam formação relevante para suas funções.
                                    </p>
                                </div>
                                <div class="row">
                                    <li class="text-nowrap"><span class="icon-check"></span>Abordagem Prática</li>
                                    <p class="">Nossos cursos incluem exercícios práticos e simulações que preparam os participantes para situações reais, aumentando a eficácia do aprendizado.</p>
                                </div>
                                <div class="row">
                                    <li class="text-nowrap"><span class="icon-check"></span>Certificação Reconhecida</li>
                                    <p class=""> Nosso centro de treinamento é equipado com infraestrutura moderna e adequada para proporcionar um ambiente de aprendizado eficaz.</p>
                                </div>
                            </ul>
                        </div>

{{--                        <a href="cursos.html" target="_blank" class="eduact-btn"><span class="eduact-btn__curve"></span>Conheça nossos cursos<i class="icon-arrow"></i></a><!-- /.btn -->--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @livewire('site.home.blog')


@stop
