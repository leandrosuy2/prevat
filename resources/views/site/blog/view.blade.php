@extends('site.layouts.app')

@section('title', 'Nosso Blog')

@section('content')
        @livewire('site.blog.view', ['id' => $id])
@stop
