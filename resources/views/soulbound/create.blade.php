@extends('layouts.app')

@section('header', __('soulbounds.create'))

@section('content')
    <x-container>
        @include('soulbound.form', ['method' => 'POST', 'action' => route('characters.soulbounds.store', $character)])
    </x-container>
@endsection
