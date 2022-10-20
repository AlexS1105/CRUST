<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('charsheet.edit.title') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('characters.fates.update', $character) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-slot name="header">
                    {{ __('charsheet.fates') }}
                </x-slot>

                <x-character.fates :character="$character" :maxFates="$settings->max_fates"/>
            </x-form.card>

            <x-button>
                {{ __('ui.submit') }}
            </x-button>
        </form>
    </x-container>
</x-app-layout>
