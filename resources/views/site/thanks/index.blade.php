@extends('site.layouts.app')

@section('title', 'Quem Somos')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">Obrigado !</h1>
        </div>
    </section>

    <section class="about-two">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="about-two__thumb wow fadeInLeft" data-wow-delay="100ms">
                        <img src="{{url('site/arquivos/blog-2-5.jpg')}}" title="Titulo da Imagem" alt="Titulo da Imagem" loading="lazy" style=" width: 100%">
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="100ms">
                    <div class="about-two__content">
                        <div class="section-title" style=" margin-top: -40px">
                            <h2 class="section-title__title">Obrigado pelo Cadastro!</h2>
                        </div>
                        <p class="about-two__content__text"><p>Ficamos agradecido por ter você como nosso cliente, nossa equipe irá analisar seu cadastro e logo após a aprovação você receberá um email confirmando a ativação do cadastro.</p>
                        <div class="about-two__box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 295 125">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M86 0.0805664H58C25.9675 0.0805664 0 26.048 0 58.0806V79.5806C0 104.157 19.9233 124.081 44.5 124.081H46.5C69.9721 124.081 89 105.053 89 81.5806C89 58.1085 108.028 39.0806 131.5 39.0806H268C282.912 39.0806 295 26.9923 295 12.0806C295 5.45315 289.627 0.0805664 283 0.0805664H89H86Z" />
                            </svg>
                            <div class="about-two__box__icon"><span class="icon-Presentation"></span></div>
                            <h4 class="about-two__box__title">Cursos dinâmicos</h4>
                            <p class="about-two__box__text">Cursos que se coordenam. Aulas que vão direto ao ponto. Profissionais experientes e pragmáticos. Formação garantida!</p>
                        </div>
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
                        <a href="{{route('login')}}" target="_blank" class="eduact-btn"><span class="eduact-btn__curve"></span>Faça seu Login<i class="icon-arrow"></i></a><!-- /.btn -->
                    </div>
                </div>
            </div>
        </div>
    </section>


@stop
