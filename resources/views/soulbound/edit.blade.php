@extends('layouts.app')

@section('header', __('soulbounds.edit'))

@section('content')
    <x-container>
        @include('soulbound.form', ['method' => 'PATCH', 'action' => route('characters.soulbounds.update', ['character' => $character, 'soulbound' => $soulbound])])
    </x-container>
@endsection
