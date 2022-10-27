@extends('layouts.app')

@section('header', __('crafts.edit'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.narrative_crafts.update', ['character' => $character, 'narrative_craft' => $narrativeCraft]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="name" required maxlength="256" :value="old('name', $narrativeCraft->name)"/>
                <x-form.input name="description" maxlength="1024"
                              :value="old('description', $narrativeCraft->description)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
