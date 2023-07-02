@extends('layouts.app')

@section('header', __('modifications.edit'))

@section('content')
    <x-container>
        @include('modification.form', ['method' => 'PATCH', 'action' => route('characters.modifications.update', ['character' => $character, 'modification' => $modification])])
    </x-container>
@endsection
