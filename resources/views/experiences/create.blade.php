@extends('layouts.app')

@section('header', __('experiences.create'))

@section('content')
    @include('experiences.form', ['method' => 'POST', 'action' => route('characters.experiences.store', $character)])
@endsection
