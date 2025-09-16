@extends('site.layouts.app')

@section('title', 'Consultoria')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h1 class="page-header__title">Consultoria</h1>
        </div>
    </section>
    <section class="blog-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12">

                        @livewire('site.consultancy.card')


                </div>
            </div>
        </div>
    </section>

@stop
