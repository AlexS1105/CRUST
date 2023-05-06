@extends('layouts.app')

@section('header', __('techniques.edit'))

@section('content')
    <x-container>
        @include('techniques.form', ['method' => 'PATCH', 'action' => route('techniques.update', $technique)])
    </x-container>
@endsection
