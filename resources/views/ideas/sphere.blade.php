@extends('layouts.app')

@section('header', __('ideas.to_sphere'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.ideas.sphere', ['character' => $character, 'idea' => $idea]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.select required :name="'sphere'" :values="$character->spheres->pluck('id')"
                               :labels="$character->spheres->pluck('name')" :value="old('sphere')"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
