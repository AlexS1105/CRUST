<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-80 h-80 fill-current text-gray-500"/>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form class="space-y-4" method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="discord_id" value="{{ $request->route('discord_id') }}">

            <x-form.input name="password" type="password" required/>
            <x-form.input name="password_confirmation" type="password" required/>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('forgot_password.reset') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
