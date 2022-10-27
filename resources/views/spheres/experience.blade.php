@extends('layouts.app')

@section('header', __('spheres.experience'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.spheres.experience', ['character' => $character, 'sphere' => $sphere]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.select required :name="'experience'" :values="$character->experiences->pluck('id')"
                               :labels="$character->experiences->pluck('name')" :value="old('experience')"/>
                <x-form.input name="value" required type="number" min="1" max="10" :value="old('value', 1)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
