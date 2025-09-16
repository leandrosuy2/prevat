@extends('site.layouts.app')

@section('title', 'Nossos Treinamentos')

@section('content')
    @livewire('site.training.view', ['id' => $id])

@stop
