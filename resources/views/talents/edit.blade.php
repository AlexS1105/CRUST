@extends('layouts.app')

@section('header', __('talents.edit'))

@section('content')
    <x-container>
        @include('talents.form', ['method' => 'PATCH', 'action' => route('talents.update', $talent)])
    </x-container>
@endsection
