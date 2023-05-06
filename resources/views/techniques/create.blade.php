@extends('layouts.app')

@section('header', __('techniques.create'))

@section('content')
    <x-container>
        @include('techniques.form', ['method' => 'POST', 'action' => route('techniques.store')])
    </x-container>
@endsection
