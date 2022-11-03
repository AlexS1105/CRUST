@extends('layouts.app')

@section('header', __('crafts.create'))

@section('content')
    @include('crafts.form', ['action' => route('characters.narrative_crafts.store', $character), 'method' => 'POST'])
@endsection
