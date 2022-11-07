@extends('layouts.app')

@section('header', __('ideas.to_sphere'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.ideas.sphere', ['character' => $character, 'idea' => $idea]) }}" method="PATCH" >
            <x-form.card>
                <x-form.select required
                               :name="'sphere'"
                               :values="$character->spheres->pluck('id')"
                               :labels="$character->spheres->pluck('name')"
                               :value="old('sphere')"/>

                <x-button-submit/>
            </x-form.card>
        </x-form.base>
    </x-container>
@endsection
