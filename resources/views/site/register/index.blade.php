@extends('site.layouts.app')

@section('styles')
@endsection

@section('title', 'Consultoria')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h2 class="page-header__title">Cadastro</h2>
        </div>
    </section>
    <section class="about-three">
        <div class="container wow fadeInUp" data-wow-delay="300ms">
            <div class="section-title  text-center">
                    <span class="section-title__tagline" style=" font-weight: bold">
                       Formulario de Cadastro
                    </span>
                <h2 class="section-title__title">Preencha os dados abaixo e faça o cadastro em nosso sistema!</h2>
            </div>
            <div class="container text-center">
                @livewire('site.register.form')
            </div>
        </div>
    </section>
    <section class="contact-info">
        @livewire('site.help.card')
    </section>

@stop
@section('scripts')

@endsection
