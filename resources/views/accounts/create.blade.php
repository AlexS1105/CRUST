<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('accounts.index') }}
        </h2>
    </x-slot>

    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('users.accounts.store', $user) }}">
            @csrf

            <x-form.card>
                <x-form.input name="login" required maxlength="16"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
