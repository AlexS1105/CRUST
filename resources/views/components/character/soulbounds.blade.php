@props([
    'character',
])

<x-card>
    <x-header>
        {{ __('soulbounds.index') }} - {{ $character->soulbounds->sum('cost') }}
    </x-header>

    <div class="md:grid md:grid-cols-2 md:gap-4 md:space-y-0 space-y-4">
        @foreach ($character->soulbounds as $soulbound)
            <x-spoiler-card type="soulbound" id="{{ $soulbound->id }}">
                <x-slot name="header">
                    {{ $soulbound->name }}
                </x-slot>

                <div class="p-2 bg-white dark:bg-gray-600 dark:text-gray-300 border-t border-gray-400 dark:border-gray-900">
                    <div class="flex justify-between">
                        <div>
                            <x-markdown>{!! $soulbound->description !!}</x-markdown>

                            <div class="text-xs text-right">
                                {{ $soulbound->created_at }} ({{ $soulbound->created_at->diffForHumans() }})
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a class="fas fa-edit text-xl text-gray-600 dark:text-gray-300"
                               href="{{ route('characters.soulbounds.edit', ['character' => $character, 'soulbound' => $soulbound]) }}"></a>

                            <form method="POST" action="{{ route('characters.soulbounds.destroy', ['character' => $character, 'soulbound' => $soulbound]) }}">
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

    @can('update-charsheet-gm', $character)
        <x-accordion-action class="my-2 w-full border-t"
                            method="GET"
                            action="{{ route('characters.soulbounds.create', $character) }}"
                            icon="fa-solid fa-plus"
        >
            {{ __('soulbounds.create') }}
        </x-accordion-action>
    @endcan
</x-card>
