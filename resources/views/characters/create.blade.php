@extends('layouts.app')

@section('header', __('characters.create'))

@section('content')
    <x-container>
        <x-character.stages/>

        @include('characters.form', ['method' => 'POST', 'action' => route('characters.store')])
    </x-container>
@endsection
