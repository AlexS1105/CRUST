@extends('layouts.app')

@section('header', __('perks.index'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.perks.update', $character->login) }}" method="PATCH">

            @if (count($perks))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('charsheet.perks') }}
                    </x-slot>

                    <x-character.perks :character="$character" :perks="$perks"
                                       :maxPerks="$settings->max_perks" />
                </x-form.card>
            @endif

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
