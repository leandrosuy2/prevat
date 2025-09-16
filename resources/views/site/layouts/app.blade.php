<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Prevat Treinamentos - @yield('title') </title>

    <meta name="description" content="Descrição">
    <meta name="keywords" content="palavras chaves">
    <meta name="robot" content="all">
    <meta name="rating" content="general">
    <meta name="language" content="pt-br">
    <meta property="og:title" content="Prevat Treinamentos">
    <meta property="og:url" content="https://www.prevat.com.br/">
    <meta property="og:image" content="endereço da imagem">
    <meta property="og:site_name" content="Nome do Site">
    <meta property="og:description" content="Descrição">
    <link href="{{url('site/midias/imagens/favicon.17049160431.png')}}" rel="icon" type="image/png">
    <link rel="canonical" href="https://www.site.com/" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Water+Brush&amp;display=swap" rel="stylesheet">
    <link href="{{url('site/arquivos/favicon.png')}}" rel="icon" type="image/png">
    <link rel="stylesheet" href="{{asset('site/assets/vendors/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('site/assets/vendors/bootstrap-select/bootstrap-select.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"   href="{{asset('site/assets/vendors/jquery-ui/jquery-ui.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/animate/animate.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/fontawesome/css/all.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/eduact-icons/style.css')}}" />
    <link href="{{asset('build/assets/iconfonts/icons.css')}}" rel="stylesheet">
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/jarallax/jarallax.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/nouislider/nouislider.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/nouislider/nouislider.pips.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/odometer/odometer.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/tiny-slider/tiny-slider.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/owl-carousel/assets/owl.carousel.min.css')}}" />
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{asset('site/assets/vendors/owl-carousel/assets/owl.theme.default.min.css')}}" />
    <link rel="stylesheet" href="{{asset('site/assets/css/prevat.css')}}" />

    <style>
        .hero-banner__thumb{ margin-top: 50px;}
        .blog-one__title { font-size: 26px; text-transform: none;    margin: 0 0 10px;}
    </style>

    @livewireStyles

</head>
<body class="custom-cursor">
<div class="page-wrapper">
    @include('site.layouts.components.header')
    <div class="stricky-header stricked-menu main-menu">
        <div class="sticky-header__content"></div>
    </div>

    @yield('content')

    @include('site.layouts.components.footer')
</div>
<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>
        <div class="logo-box">
            <a href="{{ route('home') }}" aria-label=""><img src="{{url('site/arquivos/logo-branco.png')}}" title="Nome da Empresa" alt="Nome da Empresa" loading="lazy" width="163" height="70" style="max-width: 100%; height: auto"/></a>
        </div>
        <div class="mobile-nav__container"></div>
        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fas fa-user"></i>
                <a href="{{route('login')}}">Faça seu login</a>
            </li><li>
                <i class="fa fa-pencil"></i>
                <a href="{{ route('register') }}">Faça seu cadastro</a>
            </li>
        </ul>
        <div class="mobile-nav__social">
            <a aria-label="Instagram" target="_blank" href="#" ><i class="fab fa-instagram" ></i></a>
            <a aria-label="Facebook" target="_blank" href="#" ><i class="fab fa-facebook" ></i></a>
            <a aria-label="Facebook" target="_blank" href="#" ><i class="fab fa-twitter" ></i></a>
            <a aria-label="Youtube" target="_blank" href="#" ><i class="fab fa-youtube" ></i></a>
            <a aria-label="Youtube" target="_blank" href="#" ><i class="fab fa-linkedin" ></i></a>
        </div>
    </div>
</div>

<div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <div class="search-popup__content">
        <form role="search" method="post" class="search-popup__form" action="busca.html">
            <input type="text" id="termo" name="termo" placeholder="Buscar por..." />
            <button type="submit" aria-label="Buscar" class="eduact-btn"><span class="eduact-btn__curve"></span><i class="icon-Search"></i></button>
        </form>
    </div>
</div>
<a href="#" class="scroll-top" aria-label="Ir para o topo">
    <svg class="scroll-top__circle" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</a>

@vite('resources/js/app.js')

<script src="{{asset('site/assets/vendors/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('site/assets/vendors/jarallax/jarallax.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-appear/jquery.appear.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/nouislider/nouislider.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/odometer/odometer.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/tiny-slider/tiny-slider.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/wnumb/wNumb.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-circleType/jquery.circleType.js')}}"></script>
<script src="{{asset('site/assets/vendors/jquery-lettering/jquery.lettering.min.js')}}"></script>
<script src="{{asset('site/assets/vendors/tilt/tilt.jquery.js')}}"></script>
<script src="{{asset('site/assets/vendors/wow/wow.js')}}"></script>
<script src="{{asset('site/assets/vendors/isotope/isotope.js')}}"></script>
<script src="{{asset('site/assets/vendors/countdown/countdown.min.js')}}"></script>
<script src="{{asset('site/assets/js/educat.js')}}"></script>
<script src="{{asset('site/assets/js/main.js') }}"></script>
<script src="app-adm/js/jquery.filter_input.js')}}"></script>
<script src="app-adm/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript">
    var behavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(behavior.apply({}, arguments), options);
            }
        };

    $('#telefone').mask(behavior, options);
    $('#celular').mask(behavior, options);
</script>

</body>
</html>
