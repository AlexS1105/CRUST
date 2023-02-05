@extends('layouts.app')

@section('header', __('estitence.index'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('characters.estitence.store', $character) }}">
            @csrf

            <x-form.card>
                <x-form.input name="reason" required maxlength="256" :value="old('reason')"/>
                <x-form.input name="delta" required type="number" min="-100" max="100" :value="old('delta')"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
