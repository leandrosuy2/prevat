@extends('layouts.app')

@section('title', 'Ordem de Serviço')

@section('styles')

@endsection

@section('content')

    <!-- PAGE HEADER -->
    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Financeiro</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('financial.service-order')}}">Ordem de Serviço</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vizualização PDF</li>
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
                <a href="{{ url()->previous() }}" class="btn bg-warning-transparent text-warning btn-sm" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Voltar">
                                <span>
                                    <i class="fa fa-backward"></i>
                                </span>
                </a>
                <a href="{{route('financial.service-order.create')}}" class="btn bg-success-transparent text-success btn-sm mx-2" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Nova OS">
                    <span>
                        <i class="fa fa-plus"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    @livewire('financial.service-order.pdf.card' , ['id' => $id])

@endsection

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>

    <!-- APEXCHART JS -->
    <script src="{{asset('build/assets/plugins/apexcharts/apexcharts.min.js')}}"></script>

    <!-- DATA TABLES JS -->
    <script src="{{asset('build/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('build/assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

    <!-- PERFECT-SCROLLBAR JS  -->
    <script src="{{asset('build/assets/plugins/pscrollbar/p-scroll-3.js')}}"></script>

    <!-- INDEX JS -->
    @vite('resources/assets/js/index3.js')


@endsection
