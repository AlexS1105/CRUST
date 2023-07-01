@extends('layouts.app')

@section('header', __('experience.index'))

@section('content')
    <x-container class="max-w-6xl">
        <div class="bg-white dark:bg-gray-600 rounded-xl shadow-lg p-6 w-auto">
            @can('update-charsheet-gm', $character)
                <x-link href="{{ route('characters.experience.create', $character) }}">
                    {{ __('experience.create') }}
                </x-link>
            @endcan

            @if(count($character->experienceLogs))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            {{ __('label.date') }}
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

                    @foreach ($character->experienceLogs->sortBy('created_at') as $experienceLog)
                        <x-table.row class="dark:text-gray-300 py-2 text-center">
                            <x-table.cell
                                class="px-4 py-2 border border-gray-400 {{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100 dark:{{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $experienceLog->created_at }}
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="px-4 py-2 border border-gray-400 {{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100 dark:{{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $experienceLog->delta }}

                                    <div class="text-xs">
                                        {{ $experienceLog->before }} -> {{ $experienceLog->after }}
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="px-4 py-2 border border-gray-400 {{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100 dark:{{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $experienceLog->reason }}
                                </div>
                            </x-table.cell>
                            <x-table.cell
                                class="px-4 py-2 border border-gray-400 {{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100 dark:{{ $experienceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-400">
                                <div class="dark:drop-shadow-xs">
                                    {{ $experienceLog->issuedBy?->login }}
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
