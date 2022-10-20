<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('skins.index') }}
        </h2>
    </x-slot>

    <x-container class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            <a class="font-bold underline text-blue-600 visited:text-purple-600"
               href="{{ route('characters.skins.create', $character) }}">
                {{ __('skins.create') }}
            </a>
            @if(count($character->skins))
                <table class="table-auto w-full border mt-2">
                    <thead class="border bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.prefix') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.skin') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($character->skins as $skin)
                        <tr class="py-2 border hover:bg-gray-100">
                            <td class="px-4 py-2 border">
                                {{ $skin->prefix ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                <a href="{{ Storage::url($skin->skin) }}">
                                    <img
                                        class="object-cover"
                                        src="{{ Storage::url($skin->skin).'?='.$skin->updated_at }}"
                                        alt="Character Reference"
                                    />
                                </a>
                            </td>
                            <td class="border">
                                <div class="w-min mx-auto text-center">
                                    <a class="font-bold underline text-blue-600 visited:text-purple-600 cursor-pointer"
                                       onclick="copyToClipboard('{{ Storage::url($skin->skin) }}')">
                                        {{ __('skins.copy') }}
                                    </a>
                                    <form method="POST"
                                          action="{{ route('characters.skins.destroy', ['character' => $character, 'skin' => $skin]) }}">
                                        @method('DELETE')
                                        @csrf

                                        <a
                                            class="font-bold underline text-blue-600 visited:text-purple-600 cursor-pointer"
                                            onclick="if (confirm('{{ __('ui.confirm', ['tip' => '']) }}')) { event.preventDefault();this.closest('form').submit(); }"
                                        >
                                            {{ __('skins.delete') }}
                                        </a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('skins.empty') }}
                </p>
            @endif
            <x-tip class="mt-2">
                {{ __('tips.skins.default') }}
            </x-tip>
        </div>
    </x-container>
</x-app-layout>
