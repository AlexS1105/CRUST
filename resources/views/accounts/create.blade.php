<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('accounts.index') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('users.accounts.store', $user) }}">
            @csrf

            <x-form.card>
                <x-form.input name="login" required maxlength="16"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
