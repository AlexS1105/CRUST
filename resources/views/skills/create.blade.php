@extends('layouts.app')

@section('header', __('skills.create'))

@section('content')
    <x-container>
        @include('skills.form', ['method' => 'POST', 'action' => route('skills.store')])
    </x-container>
@endsection
