@extends('layouts.app')

@section('header', __('experiences.edit'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.experiences.update', ['character' => $character, 'experience' => $experience]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="name" required maxlength="256" :value="old('name', $experience->name)"/>
                <x-form.input name="description" maxlength="1024"
                              :value="old('description', $experience->description)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
