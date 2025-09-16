@extends('site.layouts.app')

@section('title', 'Consultoria')

@section('content')
    @if(isset($id))
        @livewire('site.training.training', ['id' => $id])
    @else
        @livewire('site.training.training', ['id' => null])
    @endif
@stop
