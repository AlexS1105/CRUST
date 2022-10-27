@extends('layouts.app')

@section('header', __('experiences.set'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.experiences.set', ['character' => $character, 'experience' => $experience]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="level" required type="number" min="1" max="10"
                              :value="old('level', $experience->level)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
