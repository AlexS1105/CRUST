@extends('layouts.guest')

@section('content')
    <x-message>
        {{ __('forgot_password.message') }}
    </x-message>

    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    <x-button-discord class="w-full place-content-center"
                      :href="config('services.discord.oauth2url.reset')">
        {{ __('forgot_password.button') }}
    </x-button-discord>
@endsection
