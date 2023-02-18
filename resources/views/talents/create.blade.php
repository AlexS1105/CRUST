@extends('layouts.app')

@section('header', __('talents.create'))

@section('content')
    <x-container>
        @include('talents.form', ['method' => 'POST', 'action' => route('talents.store')])
    </x-container>
@endsection
