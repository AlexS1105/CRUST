@extends('layouts.app')

@section('header', __('experience.edit'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.experience.update', $character->login) }}" method="PATCH">
            <x-form.card>
                <x-slot name="header">
                    {{ __('experience.edit') }}
                </x-slot>

                <x-form.input name="experience" type="number" required min="0" max="1000" :value="old('experience', $character->experience)"/>
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
