@extends('layouts.app')

@section('header', __('estitence.index'))

@section('content')
    <x-container class="max-w-6xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            @can('estitence-create', $character)
                <x-link href="{{ route('characters.estitence.create', $character) }}">
                    {{ __('estitence.create') }}
                </x-link>
            @endcan
            @if(count($character->estitenceLogs))
                <table class="table-auto w-full border mt-2">
                    <thead class="border bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.date') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.amount') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.reason') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.issued_by') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($character->estitenceLogs->sortBy('created_at') as $estitenceLog)
                        <tr class="py-2 hover:{{ $estitenceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-200 text-center {{ $estitenceLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100">
                            <td class="px-4 py-2 border border-gray-400">
                                {{ $estitenceLog->created_at }}
                            </td>
                            <td class="px-4 py-2 border border-gray-400 leading-none">
                                {{ $estitenceLog->delta }}
                                <div class="text-xs">
                                    {{ $estitenceLog->before }} -> {{ $estitenceLog->after }}
                                </div>
                            </td>
                            <td class="px-4 py-2 border border-gray-400 min-w-full">
                                {{ $estitenceLog->reason }}
                            </td>
                            <td class="px-4 py-2 border border-gray-400">
                                {{ $estitenceLog->issuedBy->login }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('estitence.empty') }}
                </p>
            @endif
        </div>
    </x-container>
@endsection
