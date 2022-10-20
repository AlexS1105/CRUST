<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('settings.index') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl">
        <form method="POST" action="{{ route('settings.general.update') }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="max_characters" type="number" min="0" max="100"
                              :value="old('max_characters', $settings->max_characters)"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
