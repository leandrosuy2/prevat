@extends('layouts.app')

@section('title', 'Agenda Empresa')

@section('styles')
@endsection

@section('content')

    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Movimentações</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agenda Empresa</li>
        </ol><!-- End breadcrumb -->
        <div class="ms-auto">
            <div>
                <a href="#" class="btn bg-primary-transparent text-primary mx-2 btn-sm"
                   data-bs-toggle="tooltip" title="" data-bs-placement="bottom"
                   data-bs-original-title="lock">
                                            <span>
                                                <i class="fa fa-lock"></i>
                                            </span>
                </a>

{{--                <a href="{{route('client.movement.schedule-company.create')}}" class="btn bg-warning-transparent text-warning btn-sm" data-bs-toggle="tooltip"--}}
{{--                   title="" data-bs-placement="bottom" data-bs-original-title="Novo Treinamento">--}}
{{--                                            <span>--}}
{{--                                                <i class="fa fa-plus"></i>--}}
{{--                                            </span>--}}
{{--                </a>--}}

            </div>
        </div>
    </div>

    @livewire('contractor.schedule-company.table')

@endsection

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>


@endsection
