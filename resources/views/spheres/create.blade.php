@extends('layouts.app')

@section('header', __('spheres.create'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('characters.spheres.store', $character) }}">
            @csrf

            <x-form.card>
                <x-form.input name="name" required maxlength="256" :value="old('name')"/>
                <x-form.input name="description" maxlength="1024" :value="old('description')"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
