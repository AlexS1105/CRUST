@extends('layouts.app')

@section('header', __('attunements.create'))

@section('content')
    <x-container>
        @include('attunement.form', ['method' => 'POST', 'action' => route('characters.attunements.store', $character)])
    </x-container>
@endsection
