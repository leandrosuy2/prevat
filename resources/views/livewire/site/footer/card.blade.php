<div>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="100ms">
                <div class="main-footer__about">
                    <a href="#" class="main-footer__logo">
                        <img src="{{url('site/arquivos/logo-branco.png')}}" title="Prevat Treinamentos" alt="Prevat Treinamentos" loading="lazy" width="163" height="70" style="max-width: 100%; height: auto" >
                    </a>
                    <p class="main-footer__about__text">{{$information['text_footer'] ?? 'Texto Aqui'}}</p>
                    <div class="main-footer__social">
                        @if(isset($information['link_instagram']))
                            <a aria-label="Instagram" target="_blank" href="{{$information['link_instagram'] ?? ''}}" ><i class="fab fa-instagram" ></i></a>
                        @endif
                        @if(isset($information['link_facebook']))
                            <a aria-label="Facebook" target="_blank" href="{{$information['link_facebook']}}" ><i class="fab fa-facebook" ></i></a>
                        @endif
                        @if(isset($information['link_twitter']))
                            <a aria-label="Youtube" target="_blank" href="{{$information['link_twitter']}}" ><i class="fab fa-twitter" ></i></a>
                        @endif
                        @if(isset($information['link_youtube']))
                            <a aria-label="Youtube" target="_blank" href="{{$information['link_youtube']}}" ><i class="fab fa-youtube" ></i></a>
                        @endif
                        @if(isset($information['link_linkedin']))
                            <a aria-label="Youtube" target="_blank" href="{{$information['link_linkedin']}}" ><i class="fab fa-linkedin" ></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="200ms">
                <div class="main-footer__navmenu main-footer__widget01">
                    <h3 class="main-footer__title">Institucional</h3>
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('about')}}">Quem Somos</a></li>
                        <li><a href="{{route('courses.list')}}">Nossos Cursos</a></li>
                        <li><a href="{{route('consultancy')}}">Consultoria</a></li>
                        <li><a href="{{route('blog')}}">Blog</a></li>
                        <li><a href="{{route('contact')}}">Contato</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="300ms">
                <div class="main-footer__navmenu main-footer__widget02">
                    <h3 class="main-footer__title">Treinamentos</h3>
                    <ul>
                        @foreach($response->categories as $itemCategory)
                            <li><a href="{{route('courses', $itemCategory['id'])}}"> {{$itemCategory['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 wow fadeInUp" data-wow-delay="300ms">
                <div class="main-footer__navmenu main-footer__widget02">
                    <h3 class="main-footer__title">Ajuda</h3>
                    <ul>
                        <li><a href="{{route('terms')}}">Termos de Adesão</a></li>
                        <li><a href="{{route('policy')}}">Política de privacidade</a></li>
                        <li><a href="{{route('questions') }}">Perguntas frequentes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
