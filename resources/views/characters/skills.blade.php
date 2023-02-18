@extends('layouts.app')

@section('header', __('skills.index'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.skills.update', $character->login) }}" method="PATCH">

            @if (count($skills))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('skills.index') }}
                    </x-slot>

                    <x-character.skill-selector :character="$character" :skills="$skills" />
                </x-form.card>
            @endif

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
