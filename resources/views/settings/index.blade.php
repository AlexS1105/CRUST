@extends('layouts.app')

@section('header', __('settings.index'))

@section('content')
    <x-container class="max-w-6xl space-y-8">
        <x-card class="max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4 dark:text-gray-200">
            <h3 class="font-bold text-2xl">{{ __('settings.settings') }}</h3>

            <ul class="list-disc list-inside text-lg underline">
                <li>
                    <a href="{{ route('settings.general.show') }}">{{ __('settings.general') }}</a>
                </li>

                <li>
                    <a href="{{ route('settings.charsheet.show') }}">{{ __('settings.charsheet') }}</a>
                </li>

                <li>
                    <a href="{{ route('perks.index') }}">{{ __('perks.index') }}</a>
                </li>

                <li>
                    <a href="{{ route('skills.index') }}">{{ __('skills.index') }}</a>
                </li>

                <li>
                    <a href="{{ route('talents.index') }}">{{ __('talents.index') }}</a>
                </li>

                <li>
                    <a href="{{ route('techniques.index') }}">{{ __('techniques.index') }}</a>
                </li>
            </ul>

            <h3 class="font-bold text-2xl">{{ __('statistics.index') }}</h3>
            <ul class="list-disc list-inside text-lg underline">
                <li>
                    <a href="{{ route('statistics.summary') }}">{{ __('statistics.summary') }}</a>
                </li>
            </ul>
        </x-card>
    </x-container>
@endsection
