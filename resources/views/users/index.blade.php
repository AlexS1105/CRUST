@extends('layouts.app')

@section('header', __('users.index'))

@section('content')
    <x-container class="max-w-5xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            <x-search-field class="w-full mb-6" :search="$search" :route="route('users.index')"/>

            @if(count($users))
                <table class="table-auto w-full border">
                    <thead class="border bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('login', __('label.login'))
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('discord_tag', __('label.discord_tag'))
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.characters') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            @sortablelink('created_at', __('label.registered'))
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr class="py-2 border hover:bg-gray-100">
                            <td class="px-4 py-2 border text-center">
                                <x-link
                                   href="{{ route('users.show', $user) }}">
                                    {{ $user->login }}
                                </x-link>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <span class="select-all">{{ $user->discord_tag }}</span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                @foreach ($user->characters as $character)
                                    <x-link
                                       href="{{ route('characters.show', $character->login) }}">
                                        {{ $character->name }}
                                    </x-link>

                                    @unless ($loop->last)
                                        ,
                                    @endunless
                                @endforeach
                            </td>
                            <td class="px-4 py-2 border text-center">
                                {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                            </td>
                            <td class="border">
                                <div class="flex w-min mx-auto">
                                    <x-user.actions :user="$user" :tooltip="true"/>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('users.empty') }}
                </p>
            @endif

            <div class="pt-4">
                {{ $users->links() }}
            </div>
        </div>
    </x-container>
@endsection
