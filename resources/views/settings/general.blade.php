@extends('layouts.app')

@section('header', __('settings.index'))

@section('content')
    <x-container class="max-w-3xl">
        <form method="POST" action="{{ route('settings.general.update') }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="max_characters" type="number" min="0" max="100"
                              :value="old('max_characters', $settings->max_characters)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
