<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('charsheet.edit.title') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('characters.perks.update', $character->login) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @if (count($perks))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('charsheet.perks') }}
                    </x-slot>

                    <x-character.perks :character="$character" :perks="$perks"
                                       :maxActivePerks="$settings->max_active_perks" :edit="true"/>
                </x-form.card>
            @endif

            <x-button>
                {{ __('ui.submit') }}
            </x-button>
        </form>
    </x-container>
</x-app-layout>
