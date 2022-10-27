@extends('layouts.app')

@section('header', __('spheres.spend'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.spheres.spend', ['character' => $character, 'sphere' => $sphere]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="value" required type="number" min="1" max="100" :value="old('value')"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
