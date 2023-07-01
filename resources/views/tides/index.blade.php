@extends('layouts.app')

@section('header', __('tides.index'))

@section('content')
    <x-container class="max-w-6xl">
        <div class="bg-white dark:bg-gray-600 rounded-xl shadow-lg p-6 w-auto">
            @can('update-charsheet-gm', $character)
                <x-link href="{{ route('characters.tides.edit', $character) }}">
                    {{ __('tides.edit') }}
                </x-link>
            @endcan

            @if(count($character->tideLogs))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            {{ __('label.date') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.tide') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.amount') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.reason') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.issued_by') }}
                        </x-table.header>
                    </x-slot>

                    @foreach ($character->tideLogs->sortBy('created_at') as $tideLog)
                        <x-table.row class="dark:text-gray-300 py-2 text-center">
                            <x-table.cell>
                                <div class="dark:drop-shadow-xs">
                                    {{ $tideLog->created_at }}
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="bg-{{ $tideLog->tide->color() }}-200 dark:bg-{{ $tideLog->tide->color() }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $tideLog->tide->localized() }}
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="{{ $tideLog->delta > 0 ? 'bg-green' : 'bg-red' }}-200 dark:{{ $tideLog->delta > 0 ? 'bg-green' : 'bg-red' }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $tideLog->delta }}

                                    <div class="text-xs">
                                        {{ $tideLog->before }} -> {{ $tideLog->after }}
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="dark:drop-shadow-xs">
                                    {{ $tideLog->reason }}
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="dark:drop-shadow-xs">
                                    {{ $tideLog->issuedBy?->login }}
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 dark:text-gray-300 text-center">
                    {{ __('experience.empty') }}
                </p>
            @endif
        </div>
    </x-container>
@endsection
