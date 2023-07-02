@extends('layouts.app')

@section('header', __('modification.create'))

@section('content')
    <x-container>
        @include('modification.form', ['method' => 'POST', 'action' => route('characters.modifications.store', $character)])
    </x-container>
@endsection
