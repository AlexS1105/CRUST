@extends('layouts.app')

@section('header', __('ideas.create'))

@section('content')
    @include('ideas.form', ['action' => route('characters.ideas.store', $character), 'method' => 'POST'])
@endsection
