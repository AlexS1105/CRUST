@extends('layouts.app')

@section('header', __('characters.edit'))

@section('content')
    <x-container>
        <x-character.stages :character="$character"/>

        @include('characters.form', ['method' => 'PATCH', 'action' => route('characters.update', $character)])
    </x-container>
@endsection
