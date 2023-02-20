@extends('layouts.app')

@section('header', __('rumors.create'))

@section('content')
    <x-container>
        @include('rumors.form', ['method' => 'put', 'action' => route('rumors.update', $rumor)])
    </x-container>
@endsection
