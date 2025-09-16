@extends('layouts.app')

@section('title', 'Produtos')

@section('styles')
@endsection

@section('content')
    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('manage.product.index')}}">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Imagens </li>
        </ol><!-- End breadcrumb -->
        <div class="ms-auto">
            <div>
                <a href="{{url('lockscreen')}}" class="btn bg-primary-transparent text-primary mx-2 btn-sm"
                   data-bs-toggle="tooltip" title="" data-bs-placement="bottom"
                   data-bs-original-title="lock">
                    <span>
                        <i class="fa fa-lock"></i>
                    </span>
                </a>
                <a href="{{route('manage.product.index')}}" class="btn bg-warning-transparent text-warning btn-sm" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Voltar">
                    <span>
                        <i class="fa fa-backward"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    @livewire('manage.product-images.card', ['id' => $id])

@endsection

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')
    <!-- MODAL JS -->
    @vite('resources/assets/js/modal.js')
@endsection
