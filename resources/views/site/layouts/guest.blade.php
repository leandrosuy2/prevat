<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

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
    <link rel="stylesheet" href="{{asset('site/assets/css/eduact.css')}}" />


    @yield('styles')

</head>

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
                <i class="fas fa-envelope"></i>
                <a href="mailto:">contato@site.com.br</a>
            </li><li>
                <i class="fa fa-phone-alt"></i>
                <a href="tel:caebizz@hotmail.com">(00) 0000-0000</a>
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


<!-- APP JS -->
@vite('resources/js/app.js')


<!-- END SCRIPTS -->

</body>
</html>
