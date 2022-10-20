<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('discord.index') }}
        </h2>
    </x-slot>

    <x-card class="mx-auto max-w-md mt-8">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('discord.message') }}
        </div>

        <div class="text-center">
            <x-button class="bg-indigo-500 w-full place-content-center"
                      onclick="window.location.href='{{ route('discord.invite') }}'" type="button">
                <div class="fab fa-discord mx-2"></div>
                {{ __('discord.invite') }}
            </x-button>
        </div>
    </x-card>
</x-app-layout>
