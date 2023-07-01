@extends('layouts.app')

@section('header', __('tides.edit'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.title.update', $character->login) }}" method="PUT">
            <x-form.card>
                <x-slot name="header">
                    {{ __('title.index') }}
                </x-slot>

                <x-form.select required
                               :name="'title'"
                               :values="App\Enums\CharacterTitle::cases()"
                               :labels="array_map(function($title) { return $title->localized(); }, App\Enums\CharacterTitle::cases())"
                               :value="old('title', $character->title)"
                />
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
