@extends('layouts.app')

@section('header', __('settings.index'))

@section('content')
    <x-container class="max-w-6xl space-y-8">
        <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4">
            <div>
                <a href="{{ route('settings.general.show') }}">{{ __('settings.general') }}</a>
            </div>

            <div>
                <a href="{{ route('settings.charsheet.show') }}">{{ __('settings.charsheet') }}</a>
            </div>

            <div>
                <a href="{{ route('perks.index') }}">{{ __('perks.index') }}</a>
            </div>

            <div>
                <a href="{{ route('skills.index') }}">{{ __('skills.index') }}</a>
            </div>

            <div>
                <a href="{{ route('talents.index') }}">{{ __('talents.index') }}</a>
            </div>
        </div>
    </x-container>
@endsection
