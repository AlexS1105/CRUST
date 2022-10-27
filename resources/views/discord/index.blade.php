@extends('layouts.app')

@section('header', __('discord.index'))

@section('content')
    <x-card class="mx-auto max-w-md mt-8">
        <x-message>
            {{ __('discord.message') }}
        </x-message>

        <x-button-discord href="{{ route('discord.invite') }}">
            {{ __('discord.invite') }}
        </x-button-discord>
    </x-card>
@endsection
