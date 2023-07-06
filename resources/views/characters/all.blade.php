@extends('layouts.app')

@section('header', __('characters.all'))

@section('content')
    <div class="max-w-7xl mx-auto px-2">
        <div class="mt-6 bg-white dark:bg-gray-600 mx-auto shadow-lg p-4 rounded-xl">
            <x-search-field :search="$search" :route="route('characters.all')"/>
            <div class="flex flex-wrap gap-2 mt-2 ml-2 text-sm items-center">
                <div class="text-gray-500 dark:text-gray-400">
                    {{ __('ui.sort.title') }}:
                </div>

                <div class="text-blue-500 dark:text-blue-400 space-x-1">
                    @sortablelink('created_at', __('ui.sort.created_at'), ['perk' => $perk, 'search' => $search])
                    @sortablelink('last_online_at', __('ui.sort.last_online_at'), ['perk' => $perk, 'search' => $search])
                </div>

                @can('query-characters', App\Models\Character::class)
                    <form method="GET" action="{{ route('characters.all') }}">
                        <select name="perk" id="perk"
                                class="form-select block w-auto mt-1 border-0 rounded-full text-sm p-0 px-2 text-gray-500 dark:bg-gray-700"
                                onchange="this.form.submit()">
                            @if (!isset($perk))
                                <option>{{ __('ui.sort.perk') }}</option>
                            @endif
                            @foreach ($perks as $perkValue)
                                <option
                                    {{ $perk === strval($perkValue->id) ? 'selected' : ''}} value="{{ $perkValue->id }}">{{ $perkValue->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endcan
            </div>
        </div>

        @if (count($characters))
            <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2 mt-4">
                @foreach ($characters as $character)
                    <a href="{{ route('characters.show', $character) }}"
                       class="bg-white dark:bg-gray-600 dark:text-gray-200 rounded-xl flex-none overflow-hidden shadow-lg transition duration-150 ease-in-out transform hover:-translate-y-2 hover:scale-105">
                        <div class="flex">
                            <img
                                class="object-cover object-top h-36 w-36 dark:bg-white"
                                src="{{ $character->getResizedReference(150) . '?' . $character->updated_at }}"
                                alt="Character Reference"
                            >
                            <div class="ml-2 p-2 my-auto">
                                <div class="font-bold text-lg line-clamp-2">
                                    {{$character->name}}
                                </div>

                                @can('see-player-only-info', $character)
                                    <div class="text-gray-700 dark:text-gray-300">
                                        {{$character->login}}, {{$character->user->discord_tag}}
                                    </div>
                                @endcan

                                @isset($character->last_online_at)
                                    <div class="text-sm text-gray-400">
                                        {{Carbon\Carbon::parse($character->last_online_at)->diffForHumans()}}
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <x-text-bg>
                {{ __('characters.empty') }}
            </x-text-bg>
        @endif

        <div class="mt-4 mb-8">
            {{ $characters->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
