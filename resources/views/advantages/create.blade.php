@extends('layouts.app')

@section('header', __('advantages.create'))

@section('content')
    <x-container>
        @include('advantages.form', ['method' => 'POST', 'action' => route('advantages.store', $skill)])
    </x-container>
@endsection
