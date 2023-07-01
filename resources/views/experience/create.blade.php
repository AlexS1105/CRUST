@extends('layouts.app')

@section('header', __('experience.create'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.experience.store', $character->login) }}" method="POST">
            <x-form.card>
                <x-form.input name="reason" maxlength="100" :value="old('reason')"/>
                <x-form.input name="delta" type="number" required min="-100" max="100" :value="old('delta')"/>
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection
