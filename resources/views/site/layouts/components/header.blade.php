<header class="main-header">
    <nav class="main-menu">
        <div class="container">
            <div class="main-menu__logo">
                <a href="{{route('home')}}">
                    <img src="{{url('site/arquivos/logo-branco.png')}}" title="Prevat Treinamentos" alt="Prevat Treinamentos" loading="lazy" width="163" height="70" style="max-width: 100%; height: auto" >
                </a>
            </div>
            <div class="main-menu__nav">
                <ul class="main-menu__list">
                    <li class=""><a href="{{ route('home') }}">Home</a></li>
                    <li class=""><a class="" href="{{ route('about') }}">Sobre</a></li>
                    <li class="dropdown">
                        <a href="{{route('courses')}}">Treinamentos</a>
                        <ul>
                            @livewire('site.training.menu')
                        </ul>
                    </li>
                    <li class=""><a href="{{ route('consultancy') }}">Consultoria</a></li>
                    <li class=""><a href="{{ route('blog') }}">Blog</a></li>
                    <li class=""><a href="{{ route('contact') }}">Contato</a></li>
                </ul>
            </div>
            <div class="main-menu__right">
                <a href="#" aria-label="Menu" class="main-menu__toggler mobile-nav__toggler">
                    <i class="fa fa-bars"></i>
                </a>
                <a href="#" aria-label="Busca" class="main-menu__search search-toggler">
                    <i class="icon-Search"></i>
                </a>
                <a href="{{ route('login') }}" class="eduact-btn"><span class="eduact-btn__curve"></span>Login</a>
                <a href="{{ route('register') }}" class="eduact-btn"><span class="eduact-btn__curve"></span>Cadastre-se</a>
            </div>
        </div>
    </nav>
</header>
