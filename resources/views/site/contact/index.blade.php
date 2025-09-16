@extends('site.layouts.app')

@section('title', 'Consultoria')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h2 class="page-header__title">Contato</h2>
        </div>
    </section>
    <section class="contact-one">
        <div class="container wow fadeInUp" data-wow-delay="300ms">
            <div class="section-title  text-center">
                    <span class="section-title__tagline" style=" font-weight: bold">
                       Contato
                    </span>
                <h2 class="section-title__title">Precisa de Ajuda?</h2>
            </div>
            <div class="contact-one__form-box  text-center">
                <form action="#" class="contact-one__form contact-form-validated" novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-one__input-box">
                                <input type="text" placeholder="Nome" name="nome" id="nome">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-one__input-box">
                                <input type="email" placeholder="Email" name="email" id="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-one__input-box">
                                <input type="text" placeholder="Telefone" name="telefone" id="telefone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-one__input-box">
                                <input type="text" placeholder="Assunto" name="assunto" id="assunto">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contact-one__input-box text-message-box">
                                <textarea name="mensagem" id="mensagem" placeholder="Mensagem"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contact-one__btn-box">
                                <button type="button" class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Envia mensagem<i class="icon-arrow"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="result"></div>
            </div>
        </div>
    </section>
    <section class="contact-info">
        @livewire('site.help.card')
    </section>

@stop
