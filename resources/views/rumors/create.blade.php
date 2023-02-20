@extends('layouts.app')

@section('header', __('rumors.create'))

@section('content')
    <x-container>
        @include('rumors.form', ['method' => 'POST', 'action' => route('characters.rumors.store', $character->login)])
    </x-container>
@endsection
