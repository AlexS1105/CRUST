@extends('layouts.app')

@section('header', __('applications.index'))

@section('content')
    <x-container class="max-w-5xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            <div class="flex mb-4 gap-4 items-center">
                @foreach (App\Enums\CharacterStatus::cases() as $_status)
                    <a href="{{ route('applications.index', [ 'status' => $_status->value ]) }}"
                       class="{{ $status == $_status->value ?:"opacity-40" }}">
                        <x-character.status :status=$_status/>
                    </a>
                @endforeach

                <x-search-field class="w-full" :search="$search" :route="route('applications.index')"/>
            </div>

            @if(count($characters))
                <table class="table-auto w-full border">
                    <thead class="border bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('name', __('label.name'))
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('user.login', __('label.player'))
                        </th>
                        @unless($status == App\Enums\CharacterStatus::Blank || $status == App\Enums\CharacterStatus::Pending)
                            <th class="px-4 py-2 border border-gray-400">
                                @sortablelink('registrar.name', __('label.registrar'))
                            </th>
                        @endunless
                        @unless (isset($status))
                            <th class="px-4 py-2 border border-gray-400">
                                @sortablelink('status', __('label.status'))
                            </th>
                        @endif
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('status_updated_at', __('label.waiting'))
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($characters as $character)
                        <tr class="py-2 border hover:bg-gray-100">
                            <td class="px-4 py-2 border">
                                <x-link href="{{ route('characters.show', $character->login) }}">
                                    {{ $character->name }}
                                </x-link>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <x-link href="{{ route('users.show', $character->user) }}">
                                    {{ $character->user->login }}
                                </x-link>
                            </td>
                            @unless($status == App\Enums\CharacterStatus::Blank || $status == App\Enums\CharacterStatus::Pending)
                                <td class="px-4 py-2 border text-center">
                                    {{ $character->registrar ? $character->registrar->login : "" }}
                                </td>
                            @endunless
                            @unless (isset($status))
                                <td class="px-4 py-2 border text-center">
                                    <x-character.status :status="$character->status"/>
                                </td>
                            @endunless
                            <td class="px-4 py-2 border text-center">
                                {{ Carbon\Carbon::parse($character->status_updated_at)->diffForHumans() }}
                            </td>
                            <td class="border">
                                <div class="flex w-min mx-auto">
                                    <x-application.actions :character="$character" :icons="true"/>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('characters.empty') }}
                </p>
            @endif

            <div class="pt-4">
                {{ $characters->appends(request()->query())->links() }}
            </div>
        </div>
    </x-container>
@endsection
