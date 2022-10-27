@extends('layouts.app')

@section('header', __('spheres.edit'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.spheres.update', ['character' => $character, 'sphere' => $sphere]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="name" required maxlength="256" :value="old('name', $sphere->name)"/>
                <x-form.input name="description" maxlength="1024" :value="old('description', $sphere->description)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
