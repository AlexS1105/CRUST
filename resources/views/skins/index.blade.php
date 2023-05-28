@extends('layouts.app')

@section('header', __('skins.index'))

@section('content')
    <x-container class="max-w-2xl">
        <div class="bg-white dark:bg-gray-600 dark:text-gray-200 rounded-xl shadow-lg p-6 w-auto">
            <x-link
               href="{{ route('characters.skins.create', $character) }}">
                {{ __('skins.create') }}
            </x-link>
            @if(count($skins))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            {{ __('label.prefix') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.skin') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.actions') }}
                        </x-table.header>
                    </x-slot>
                    @foreach ($skins as $skin)
                        <x-table.row>
                            <x-table.cell>
                                {{ $skin['prefix'] }}
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{ $skin['url'] }}">
                                    <img
                                        class="object-cover"
                                        src="{{ $skin['url'] }}"
                                        alt="Character Skin"
                                        width="128"
                                        height="128"
                                    />
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="w-min mx-auto text-center">
                                    <x-link class="cursor-pointer"
                                       onclick="copyToClipboard('{{ $skin['copy_url'] }}')">
                                        {{ __('skins.copy') }}
                                    </x-link>
                                    <form method="POST"
                                          action="{{ route('characters.skins.destroy',['character' => $character, 'prefix' => $skin['prefix']]) }}">
                                        @method('DELETE')
                                        @csrf

                                        <x-link
                                            class="font-bold cursor-pointer"
                                            onclick="if (confirm('{{ __('ui.confirm', ['tip' => '']) }}')) { event.preventDefault();this.closest('form').submit(); }"
                                        >
                                            {{ __('skins.delete') }}
                                        </x-link>
                                    </form>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>
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
@endsection
