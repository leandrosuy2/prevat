@extends('layouts.app')

@section('title', 'Evidências')

@section('styles')
@endsection

@section('content')

    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Movimentações</a></li>
            <li class="breadcrumb-item active" aria-current="page">Evidência</li>
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
{{--                @can('add_schedule_prevat')--}}
                <a href="{{route('movement.evidence.create')}}" class="btn bg-warning-transparent text-warning btn-sm" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Cadastrar">
                                            <span>
                                                <i class="fa fa-plus"></i>
                                            </span>
                </a>
{{--                @endcan--}}
            </div>
        </div>
    </div>

    @livewire('movement.evidence.table')

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
