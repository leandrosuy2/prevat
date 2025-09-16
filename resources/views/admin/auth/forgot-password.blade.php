@extends('site.layouts.app')

@section('styles')

@endsection

@section('content')
    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h2 class="page-header__title">Recuperar Senha</h2>
        </div>
    </section>
    <section class="contact-one">
        <div class="container wow fadeInUp" data-wow-delay="300ms">
            <div class="section-title  text-center">
                    <span class="section-title__tagline" style=" font-weight: bold">
                       Esqueceu a Senha ?
                    </span>
                <h4 class="section-title__title">Sem problemas. Apenas informe seu endereço de e-mail que enviaremos um link que permitirá definir uma nova senha.</h4>
            </div>
            <div class="contact-one__form-box  text-center">
                @livewire('auth.recovery')
            </div>
        </div>
    </section>
    <section class="contact-info">
        @livewire('site.help.card')
    </section>
@endsection

@section('scripts')

@endsection
