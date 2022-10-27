@extends('layouts.app')

@section('header', __('ideas.edit'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.ideas.update', ['character' => $character, 'idea' => $idea]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="name" required maxlength="256" :value="old('name', $idea->name)"/>
                <x-form.input name="description" maxlength="1024" :value="old('description', $idea->description)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
