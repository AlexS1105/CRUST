@extends('layouts.app')

@section('header', __('crafts.edit'))

@section('content')
    @include('crafts.form', ['action' => route('characters.narrative_crafts.store', $character), 'method' => 'PATCH'])
@endsection
