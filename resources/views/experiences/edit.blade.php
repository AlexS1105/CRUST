@extends('layouts.app')

@section('header', __('experiences.edit'))

@section('content')
    @include('experiences.form', ['method' => 'PATCH', 'action' => route('characters.experiences.update', ['character' => $character, 'experience' => $experience])])
@endsection
