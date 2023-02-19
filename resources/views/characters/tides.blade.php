@extends('layouts.app')

@section('header', __('tides.update'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.tides.update', $character->login) }}" method="PATCH">
            <x-form.card>
                <x-slot name="header">
                    {{ __('tides.index') }}
                </x-slot>

                <x-character.tides-edit :character="$character" />
                <x-tip text="character.tides"/>
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
