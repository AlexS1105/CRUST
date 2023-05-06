@extends('layouts.app')

@section('header', __('advantages.edit'))

@section('content')
    <x-container>
        @include('advantages.form', ['method' => 'PATCH', 'action' => route('advantages.update', ['skill' => $skill, 'advantage' => $advantage])])
    </x-container>
@endsection
