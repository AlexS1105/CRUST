@extends('layouts.app')

@section('header', __('ideas.edit'))

@section('content')
    @include('ideas.form', ['action' => route('characters.ideas.update', ['character' => $character, 'idea' => $idea]), 'method' => 'PATCH'])
@endsection
