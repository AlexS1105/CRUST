@extends('layouts.app')

@section('header', __('techniques.index'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.techniques.update', $character->login) }}" method="PATCH">

            @if (count($techniques))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('techniques.index') }}
                    </x-slot>

                    <x-character.techniques :character="$character" :techniques="$techniques" />
                </x-form.card>
            @endif

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
