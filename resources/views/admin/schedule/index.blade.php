@extends('layouts.app')

@section('title', 'Agenda Semanal')

@section('styles')
@endsection

@section('content')


    @livewire('schedule.index')

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
