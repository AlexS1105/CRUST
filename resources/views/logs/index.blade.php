@extends('layouts.app')

@section('header', __('logs.index'))

@section('content')
    <x-container class="max-w-6xl space-y-8">
        <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4">
            <div>
                <a href="{{ route('logs.crust') }}">{{ __('logs.crust') }}</a>
            </div>

            <div>
                <a href="{{ route('logs.ingame') }}">{{ __('logs.ingame') }}</a>
            </div>
        </div>
    </x-container>
@endsection
