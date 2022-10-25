<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('vox.index') }}
        </h2>
    </x-slot>

    <x-container class="max-w-6xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            @can('vox-create', $character)
                <a class="font-bold underline text-blue-600 visited:text-purple-600"
                   href="{{ route('characters.vox.create', $character) }}">
                    {{ __('vox.create') }}
                </a>
            @endcan
            @if(count($character->voxLogs))
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
                    @foreach ($character->voxLogs->sortBy('created_at') as $voxLog)
                        <tr class="py-2 hover:{{ $voxLog->delta > 0 ? 'bg-green' : 'bg-red' }}-200 text-center {{ $voxLog->delta > 0 ? 'bg-green' : 'bg-red' }}-100">
                            <td class="px-4 py-2 border border-gray-400">
                                {{ $voxLog->created_at }}
                            </td>
                            <td class="px-4 py-2 border border-gray-400 leading-none">
                                {{ $voxLog->delta }}
                                <div class="text-xs">
                                    {{ $voxLog->before }} -> {{ $voxLog->after }}
                                </div>
                            </td>
                            <td class="px-4 py-2 border border-gray-400 min-w-full">
                                {{ $voxLog->reason }}
                            </td>
                            <td class="px-4 py-2 border border-gray-400">
                                {{ $voxLog->issuedBy->login }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('vox.empty') }}
                </p>
            @endif
        </div>
    </x-container>
</x-app-layout>
