@extends('layouts.guest')

@section('content')
    <x-message>
        {{ __('auth.confirm_password') }}
    </x-message>

    <x-auth-validation-errors/>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <x-form.input name="password" type="password" autocomplete="current-password" required/>

        <div class="flex justify-end mt-4">
            <x-button>
                {{ __('ui.continue') }}
            </x-button>
        </div>
    </form>
@endsection
