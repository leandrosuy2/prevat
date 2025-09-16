@extends('layouts.app')

@section('styles')
    <link href="{{ url('pdf/web/modern-normalize.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/web/web-base.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/invoice.css')}}" rel="stylesheet" />
@endsection

@section('content')

@section('content')

    <div class="page-header d-sm-flex d-block">
        <ol class="breadcrumb mb-sm-0 mb-3">
            <!-- breadcrumb -->
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Movimentações</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('movement.schedule-prevat')}}">Agenda Prevat</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Conteúdo Programático </li>
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
                {{--                @can('add_training')--}}
                <a href="{{route('movement.schedule-prevat.create')}}" class="btn bg-warning-transparent text-warning btn-sm" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Cadastrar">
                                        <span>
                                            <i class="fa fa-plus"></i>
                                        </span>
                </a>
                {{--                @endcan--}}
                <a href="{{route('movement.schedule-prevat')}}" class="btn bg-danger-transparent text-danger mx-2 btn-sm" data-bs-toggle="tooltip"
                   title="" data-bs-placement="bottom" data-bs-original-title="Voltar">
                    <span>
                        <i class="fa fa-backward"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    @livewire('movement.schedule-prevat.programmatic.card' , ['id' => $id])

    @endsection

@section('scripts')


@endsection
