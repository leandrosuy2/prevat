@extends('layouts.app')

@section('title', 'Sem Contrado')

@section('styles')
@endsection

@section('content')

    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sem Contrato </li>
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
            </div>
        </div>
    </div>

    <div class="row mt-9">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-body p-4 text-dark">
                    <div class="statistics-info">
                        <div class="row text-center">
                            <div class="col-lg-12 col-md-6 mt-4 mb-4">
                                <div class="counter-status">

                                    <i class="fa-solid fa-circle-arrow-up text-danger fs-40 p-15"></i>

                                    <p class="mb-2">Olá! {{auth()->user()->name}}</p>
                                    <h2 class="counter text-danger mb-0">Para usar o sistema você precisa escolher um contrato acima !</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>

    <!-- DATA TABLES JS -->
    <script src="{{asset('build/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

    <!-- INDEX JS -->
    @vite('resources/assets/js/index3.js')

    @vite('resources/assets/js/modal.js')

@endsection
