@extends('layouts.app')

@section('header', __('crafts.edit'))

@section('content')
    @include('crafts.form', ['action' => route('characters.narrative_crafts.update', ['character' => $character, 'narrative_craft' => $narrativeCraft]), 'method' => 'PATCH'])
@endsection
