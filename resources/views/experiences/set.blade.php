@extends('layouts.app')

@section('header', __('experiences.set'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.experiences.set', ['character' => $character, 'experience' => $experience]) }}" method="PATCH">
            <x-form.card>
                <x-form.input name="level"
                              required
                              type="number"
                              min="1"
                              max="10"
                              :value="old('level', $experience->level)"
                />

                <x-button-submit/>
            </x-form.card>
        </x-form.base>
    </x-container>
@endsection
