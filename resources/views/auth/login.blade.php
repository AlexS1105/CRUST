@extends('layouts.guest')

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    <form class='space-y-2' method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input name="login" autofocus required/>
        <x-form.input name="password" type="password" autocomplete="current-password" required/>
        <x-form.checkbox name="remember_me"/>

        <div class="flex items-center justify-end mt-4 space-x-3">
            <x-button-discord :href="config('services.discord.oauth2url.login')">
                {{ __('login.register') }}
            </x-button-discord>

            <x-button>
                {{ __('login.button') }}
            </x-button>
        </div>

        <x-link href="{{ route('password.request') }}">
            {{ __('login.forgot') }}
        </x-link>
    </form>
@endsection
