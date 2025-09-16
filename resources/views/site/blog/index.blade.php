@extends('site.layouts.app')

@section('title', 'Consultoria')

@section('content')

    <section class="page-header page-header--bg-two"  data-jarallax data-speed="0.3" data-imgPosition="50% -100%">
        <div class="page-header__bg jarallax-img"></div>
        <div class="page-header__overlay"></div>
        <div class="container text-center">
            <h2 class="page-header__title">Blog</h2>
        </div>
    </section>
    <section class="blog-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    @livewire('site.blog.card')
                </div>
                <div class="col-xl-4 col-lg-5 wow fadeInRight" data-wow-delay="300ms">
                    @livewire('site.blog.categories.card')
                </div>
            </div>
        </div>
    </section>

@stop
