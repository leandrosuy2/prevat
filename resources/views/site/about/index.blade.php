@extends('site.layouts.app')

@section('title', 'Quem Somos')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">Quem Somos</h1>
        </div>
    </section>
    <section class="about-two about-two--about" style=" padding-top: 90px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="100ms">
                    <div class="about-two__content">
                        <div class="section-title">
                            <h2 class="section-title__title">Sobre a PrevAT</h2>
                        </div>
                        <p>Fundada em 2014, a PREVAT TREINAMENTOS reúne uma equipe de especialistas com vasta experiência em diversas áreas de atuação. Com um compromisso inabalável com a qualidade e a excelência, oferecemos um ambiente de aprendizado dinâmico e interativo, onde cada participante é encorajado a explorar seu potencial máximo.</p>
                    </div>
                </div>
                <div class="col-xl-6">
                    <img src="{{url('site/arquivos/logo-c.png')}}" title="Quem Somos" alt="Quem Somos" loading="lazy" style=" width: 100%">
                </div>
                <div class="col-xl-12 wow fadeInRight" data-wow-delay="100ms" style=" padding-top: 0px">
                    <div class="about-two__content" style=" padding-top: 0px">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec nec augue ullamcorper, suscipit ipsum eget, lobortis ex. Cras eu mollis eros. Etiam sodales massa dictum velit pharetra porta. Vivamus feugiat, nisl nec sagittis elementum, erat erat molestie dolor, ac lobortis lacus sem ut neque. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam et justo eu massa viverra aliquam id id nunc. Suspendisse egestas suscipit nulla, vitae auctor erat pellentesque cursus.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec nec augue ullamcorper, suscipit ipsum eget, lobortis ex. Cras eu mollis eros. Etiam sodales massa dictum velit pharetra porta. Vivamus feugiat, nisl nec sagittis elementum, erat erat molestie dolor, ac lobortis lacus sem ut neque. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam et justo eu massa viverra aliquam id id nunc. Suspendisse egestas suscipit nulla, vitae auctor erat pellentesque cursus.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec nec augue ullamcorper, suscipit ipsum eget, lobortis ex. Cras eu mollis eros. Etiam sodales massa dictum velit pharetra porta. Vivamus feugiat, nisl nec sagittis elementum, erat erat molestie dolor, ac lobortis lacus sem ut neque. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam et justo eu massa viverra aliquam id id nunc. Suspendisse egestas suscipit nulla, vitae auctor erat pellentesque cursus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonial-two" style="background-image: url(assets/images/shapes/testimonial-bg-2.webp);  padding-top: 30px" >
        <div class="container">
            <div class="section-title text-center">
                    <span class="section-title__tagline" style=' font-weight: bold'>
                        Depoimentos                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 133 13" fill="none">
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
                <h2 class="section-title__title">Já são mais de 300 <br />alunos satisfeitos</h2>
            </div>
            <div class="testimonial-two__carousel eduact-owl__carousel owl-with-shadow owl-theme owl-carousel" data-owl-options='{
            "items": 3,
            "margin": 30,
            "smartSpeed": 700,
            "loop":true,
            "autoplay": true,
            "center": true,
            "nav":true,
            "dots":false,
            "navText": ["<span class=\"icon-arrow-left\"></span>","<span class=\"icon-arrow\"></span>"],
            "responsive":{
                "0":{
                    "items":1,
                    "margin": 0
                },
                "700":{
                    "items": 1
                },
                "992":{
                    "items": 3
                },
                "1200":{
                    "margin": 36,
                    "items": 3
                }
            }
            }'>
                <div class="item">
                    <div class="testimonial-two__item">
                        <div class="testimonial-two__item-inner" style="background-image: url(assets/images/shapes/testimonial-shape-2.webp);">
                            <div class="testimonial-two__ratings">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="testimonial-two__quote">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec </p>
                            </div>
                            <div class="testimonial-two__meta">
                                <img src="arquivos/depoimentos.png" alt="Matteus Fernandes" loading="lazy" width="50" height="50" style=" max-width: 100%; height: auto;">
                                <h5 class="testimonial-two__title">Nome da Pessoa</h5>
                                <span class="testimonial-two__designation">Aluno</span>
                            </div>
                            <svg viewBox="0 0 416 249" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_324_36064)">
                                    <path d="M296.443 526.351C291.626 517.219 286.22 508.4 280.351 499.907C274.064 490.803 267.257 482.07 260.072 473.662C252.166 464.412 243.802 455.551 235.132 447.015C225.525 437.563 215.537 428.493 205.305 419.728C193.907 409.977 182.21 400.591 170.293 391.477C157.025 381.325 143.506 371.508 129.809 361.934C114.574 351.278 99.1373 340.919 83.5681 330.773C66.2815 319.506 48.8344 308.493 31.2774 297.659C11.8453 285.67 -7.71089 273.899 -27.3627 262.269C-49.0253 249.452 -70.8004 236.801 -92.632 224.268C-112.751 212.719 -132.553 200.599 -151.773 187.605C-167.672 176.859 -183.186 165.529 -198.079 153.411C-210.223 143.528 -221.954 133.126 -233.015 122.043C-242.024 113.01 -250.588 103.518 -258.425 93.4561C-264.651 85.4701 -270.424 77.1028 -275.483 68.3262C-279.503 61.3457 -283.079 54.0865 -285.969 46.5676C-288.192 40.7857 -290.021 34.8356 -291.27 28.7606C-292.209 24.2029 -292.822 19.5763 -292.986 14.9289C-293.101 11.7908 -293.016 8.64358 -292.628 5.53246C-292.424 3.91736 -292.165 2.29171 -291.728 0.72597C-291.679 0.529505 -291.617 0.330416 -291.559 0.139576C-291.56 1.6512 -291.422 3.17245 -291.258 4.67452C-290.799 8.90587 -289.976 13.0825 -288.939 17.2111C-287.309 23.703 -285.103 30.0422 -282.479 36.194C-278.927 44.5375 -274.604 52.5471 -269.706 60.1738C-263.507 69.8349 -256.393 78.8972 -248.649 87.3719C-238.942 97.9926 -228.245 107.691 -216.918 116.571C-203.009 127.487 -188.159 137.18 -172.79 145.896C-153.752 156.686 -133.883 165.972 -113.594 174.141C-88.9088 184.08 -63.5671 192.361 -37.9282 199.441C-11.3405 206.779 15.589 212.887 42.7613 217.66C67.4471 221.999 92.326 225.272 117.29 227.514C141.053 229.653 164.9 230.869 188.764 231.226C211.313 231.559 233.873 231.113 256.392 229.925C277.174 228.838 297.929 227.116 318.614 224.801C337.536 222.679 356.4 220.056 375.184 216.945C391.68 214.211 408.11 211.094 424.452 207.59C438.374 204.605 452.242 201.341 466.025 197.777C476.913 194.966 487.745 191.97 498.512 188.749C506.072 186.491 513.591 184.133 521.068 181.624C524.972 180.313 528.87 178.974 532.737 177.541C533.207 177.365 533.677 177.189 534.148 177.014L296.443 526.351Z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial-two__item">
                        <div class="testimonial-two__item-inner" style="background-image: url(assets/images/shapes/testimonial-shape-2.webp);">
                            <div class="testimonial-two__ratings">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="testimonial-two__quote">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec </p>
                            </div>
                            <div class="testimonial-two__meta">
                                <img src="arquivos/depoimentos.png" alt="Matteus Fernandes" loading="lazy" width="50" height="50" style=" max-width: 100%; height: auto;">
                                <h5 class="testimonial-two__title">Nome da Pessoa</h5>
                                <span class="testimonial-two__designation">Aluno</span>
                            </div>
                            <svg viewBox="0 0 416 249" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_324_36064)">
                                    <path d="M296.443 526.351C291.626 517.219 286.22 508.4 280.351 499.907C274.064 490.803 267.257 482.07 260.072 473.662C252.166 464.412 243.802 455.551 235.132 447.015C225.525 437.563 215.537 428.493 205.305 419.728C193.907 409.977 182.21 400.591 170.293 391.477C157.025 381.325 143.506 371.508 129.809 361.934C114.574 351.278 99.1373 340.919 83.5681 330.773C66.2815 319.506 48.8344 308.493 31.2774 297.659C11.8453 285.67 -7.71089 273.899 -27.3627 262.269C-49.0253 249.452 -70.8004 236.801 -92.632 224.268C-112.751 212.719 -132.553 200.599 -151.773 187.605C-167.672 176.859 -183.186 165.529 -198.079 153.411C-210.223 143.528 -221.954 133.126 -233.015 122.043C-242.024 113.01 -250.588 103.518 -258.425 93.4561C-264.651 85.4701 -270.424 77.1028 -275.483 68.3262C-279.503 61.3457 -283.079 54.0865 -285.969 46.5676C-288.192 40.7857 -290.021 34.8356 -291.27 28.7606C-292.209 24.2029 -292.822 19.5763 -292.986 14.9289C-293.101 11.7908 -293.016 8.64358 -292.628 5.53246C-292.424 3.91736 -292.165 2.29171 -291.728 0.72597C-291.679 0.529505 -291.617 0.330416 -291.559 0.139576C-291.56 1.6512 -291.422 3.17245 -291.258 4.67452C-290.799 8.90587 -289.976 13.0825 -288.939 17.2111C-287.309 23.703 -285.103 30.0422 -282.479 36.194C-278.927 44.5375 -274.604 52.5471 -269.706 60.1738C-263.507 69.8349 -256.393 78.8972 -248.649 87.3719C-238.942 97.9926 -228.245 107.691 -216.918 116.571C-203.009 127.487 -188.159 137.18 -172.79 145.896C-153.752 156.686 -133.883 165.972 -113.594 174.141C-88.9088 184.08 -63.5671 192.361 -37.9282 199.441C-11.3405 206.779 15.589 212.887 42.7613 217.66C67.4471 221.999 92.326 225.272 117.29 227.514C141.053 229.653 164.9 230.869 188.764 231.226C211.313 231.559 233.873 231.113 256.392 229.925C277.174 228.838 297.929 227.116 318.614 224.801C337.536 222.679 356.4 220.056 375.184 216.945C391.68 214.211 408.11 211.094 424.452 207.59C438.374 204.605 452.242 201.341 466.025 197.777C476.913 194.966 487.745 191.97 498.512 188.749C506.072 186.491 513.591 184.133 521.068 181.624C524.972 180.313 528.87 178.974 532.737 177.541C533.207 177.365 533.677 177.189 534.148 177.014L296.443 526.351Z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial-two__item">
                        <div class="testimonial-two__item-inner" style="background-image: url(assets/images/shapes/testimonial-shape-2.webp);">
                            <div class="testimonial-two__ratings">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="testimonial-two__quote">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim dui, imperdiet eget commodo eget, consectetur sed mauris. Maecenas ultrices odio porttitor, condimentum neque nec, posuere libero. Sed sed sapien non ipsum iaculis consectetur sed in nisl. In sed hendrerit risus. Donec </p>
                            </div>
                            <div class="testimonial-two__meta">
                                <img src="arquivos/depoimentos.png" alt="Matteus Fernandes" loading="lazy" width="50" height="50" style=" max-width: 100%; height: auto;">
                                <h5 class="testimonial-two__title">Nome da Pessoa</h5>
                                <span class="testimonial-two__designation">Aluno</span>
                            </div>
                            <svg viewBox="0 0 416 249" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_324_36064)">
                                    <path d="M296.443 526.351C291.626 517.219 286.22 508.4 280.351 499.907C274.064 490.803 267.257 482.07 260.072 473.662C252.166 464.412 243.802 455.551 235.132 447.015C225.525 437.563 215.537 428.493 205.305 419.728C193.907 409.977 182.21 400.591 170.293 391.477C157.025 381.325 143.506 371.508 129.809 361.934C114.574 351.278 99.1373 340.919 83.5681 330.773C66.2815 319.506 48.8344 308.493 31.2774 297.659C11.8453 285.67 -7.71089 273.899 -27.3627 262.269C-49.0253 249.452 -70.8004 236.801 -92.632 224.268C-112.751 212.719 -132.553 200.599 -151.773 187.605C-167.672 176.859 -183.186 165.529 -198.079 153.411C-210.223 143.528 -221.954 133.126 -233.015 122.043C-242.024 113.01 -250.588 103.518 -258.425 93.4561C-264.651 85.4701 -270.424 77.1028 -275.483 68.3262C-279.503 61.3457 -283.079 54.0865 -285.969 46.5676C-288.192 40.7857 -290.021 34.8356 -291.27 28.7606C-292.209 24.2029 -292.822 19.5763 -292.986 14.9289C-293.101 11.7908 -293.016 8.64358 -292.628 5.53246C-292.424 3.91736 -292.165 2.29171 -291.728 0.72597C-291.679 0.529505 -291.617 0.330416 -291.559 0.139576C-291.56 1.6512 -291.422 3.17245 -291.258 4.67452C-290.799 8.90587 -289.976 13.0825 -288.939 17.2111C-287.309 23.703 -285.103 30.0422 -282.479 36.194C-278.927 44.5375 -274.604 52.5471 -269.706 60.1738C-263.507 69.8349 -256.393 78.8972 -248.649 87.3719C-238.942 97.9926 -228.245 107.691 -216.918 116.571C-203.009 127.487 -188.159 137.18 -172.79 145.896C-153.752 156.686 -133.883 165.972 -113.594 174.141C-88.9088 184.08 -63.5671 192.361 -37.9282 199.441C-11.3405 206.779 15.589 212.887 42.7613 217.66C67.4471 221.999 92.326 225.272 117.29 227.514C141.053 229.653 164.9 230.869 188.764 231.226C211.313 231.559 233.873 231.113 256.392 229.925C277.174 228.838 297.929 227.116 318.614 224.801C337.536 222.679 356.4 220.056 375.184 216.945C391.68 214.211 408.11 211.094 424.452 207.59C438.374 204.605 452.242 201.341 466.025 197.777C476.913 194.966 487.745 191.97 498.512 188.749C506.072 186.491 513.591 184.133 521.068 181.624C524.972 180.313 528.87 178.974 532.737 177.541C533.207 177.365 533.677 177.189 534.148 177.014L296.443 526.351Z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
