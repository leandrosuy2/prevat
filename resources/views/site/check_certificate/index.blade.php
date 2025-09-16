@extends('site.layouts.app')

@section('title', 'Quem Somos')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">Consulta de Certificado</h1>
        </div>
    </section>

    @livewire('site.check-certificate.view', ['reference' => $reference])


@stop
