@extends('layouts.app')

@section('header', __('attunements.edit'))

@section('content')
    <x-container>
        @include('attunement.form', ['method' => 'PATCH', 'action' => route('characters.attunements.update', ['character' => $character, 'attunement' => $attunement])])
    </x-container>
@endsection
