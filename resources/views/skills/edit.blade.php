@extends('layouts.app')

@section('header', __('skills.edit'))

@section('content')
    <x-container>
        @include('skills.form', ['method' => 'PATCH', 'action' => route('skills.update', $skill)])
    </x-container>
@endsection
