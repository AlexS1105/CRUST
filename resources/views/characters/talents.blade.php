@extends('layouts.app')

@section('header', __('talents.index'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.talents.update', $character->login) }}" method="PATCH">

            @if (count($talents))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('talents.index') }}
                    </x-slot>

                    <x-character.talents :character="$character" :talents="$talents" />
                </x-form.card>
            @endif

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
