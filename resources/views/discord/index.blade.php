<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('discord.index') }}
        </h2>
    </x-slot>

    <x-card class="mx-auto max-w-md mt-8">
        <x-message>
            {{ __('discord.message') }}
        </x-message>

        <x-button-discord href="{{ route('discord.invite') }}">
            {{ __('discord.invite') }}
        </x-button-discord>
    </x-card>
</x-app-layout>
