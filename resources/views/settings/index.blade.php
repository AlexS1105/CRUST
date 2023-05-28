@extends('layouts.app')

@section('header', __('settings.index'))

@section('content')
    <x-container class="max-w-6xl space-y-8">
        <x-card class="max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4 dark:text-gray-200 font-bold text-lg underline">
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

            <div>
                <a href="{{ route('techniques.index') }}">{{ __('techniques.index') }}</a>
            </div>
        </x-card>
    </x-container>
@endsection
