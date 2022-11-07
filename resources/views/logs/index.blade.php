@extends('layouts.app')

@section('header', __('logs.index'))

@section('content')
    <x-container>
        <x-card class="flex flex-wrap gap-2">
            <x-link-button href="{{ route('logs.crust') }}">{{ __('logs.crust') }}</x-link-button>
        </x-card>
    </x-container>
@endsection
