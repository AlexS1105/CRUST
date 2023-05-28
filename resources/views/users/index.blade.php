@extends('layouts.app')

@section('header', __('users.index'))

@section('content')
    <x-container>
        <x-card class="p-6">
            <x-search-field class="w-full mb-6" :search="$search" :route="route('users.index')"/>

            @if(count($users))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            @sortablelink('login', __('label.login'))
                        </x-table.header>
                        <x-table.header>
                            @sortablelink('discord_tag', __('label.discord_tag'))
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.characters') }}
                        </x-table.header>
                        <x-table.header>
                            @sortablelink('created_at', __('label.registered'))
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.actions') }}
                        </x-table.header>
                    </x-slot>
                    @foreach ($users as $user)
                        <x-table.row>
                            <x-table.cell>
                                <x-link
                                   href="{{ route('users.show', $user) }}">
                                    {{ $user->login }}
                                </x-link>
                            </x-table.cell>
                            <x-table.cell>
                                <span class="select-all">{{ $user->discord_tag }}</span>
                            </x-table.cell>
                            <x-table.cell>
                                @foreach ($user->characters as $character)
                                    <x-link
                                       href="{{ route('characters.show', $character->login) }}">
                                        {{ $character->name }}
                                    </x-link>

                                    @unless ($loop->last)
                                        ,
                                    @endunless
                                @endforeach
                            </x-table.cell>
                            <x-table.cell>
                                {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex flex-wrap justify-center">
                                    <x-user.actions :user="$user" :tooltip="true"/>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('users.empty') }}
                </p>
            @endif

            <div class="pt-4">
                {{ $users->links() }}
            </div>
        </x-card>
    </x-container>
@endsection
