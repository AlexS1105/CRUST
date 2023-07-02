@props([
    'character',
])

<x-card>
    <x-header>
        {{ __('attunements.index') }} ({{ $character->attunements->count() }} / {{ $character->attunement_slots }})
    </x-header>

    <div class="md:grid md:grid-cols-2 md:gap-4 md:space-y-0 space-y-4">
        @foreach ($character->attunements as $attunement)
            <x-spoiler-card type="attunement" id="{{ $attunement->id }}">
                <x-slot name="header">
                    {{ $attunement->name }}
                </x-slot>

                <div class="p-2 bg-white dark:bg-gray-600 dark:text-gray-300 border-t border-gray-400 dark:border-gray-900">
                    <div class="flex justify-between">
                        <x-markdown>{!! $attunement->description !!}</x-markdown>

                        <div class="flex space-x-2">
                            <a class="fas fa-edit text-xl text-gray-600 dark:text-gray-300"
                               href="{{ route('characters.attunements.edit', ['character' => $character, 'attunement' => $attunement]) }}"></a>

                            <form method="POST" action="{{ route('characters.attunements.destroy', ['character' => $character, 'attunement' => $attunement]) }}">
                                @method('DELETE')
                                @csrf

                                <a class="fas fa-trash cursor-pointer text-xl text-gray-600 dark:text-gray-300"
                                   onclick="event.preventDefault();this.closest('form').submit();"></a>
                            </form>
                        </div>
                    </div>
                </div>
            </x-spoiler-card>
        @endforeach
    </div>

    @can('add-attunement', $character)
        <x-accordion-action class="my-2 w-full border-t"
                            method="GET"
                            action="{{ route('characters.attunements.create', $character) }}"
                            icon="fa-solid fa-plus"
        >
            {{ __('attunements.create') }}
        </x-accordion-action>
    @endcan
</x-card>
