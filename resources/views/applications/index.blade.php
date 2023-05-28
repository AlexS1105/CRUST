@extends('layouts.app')

@section('header', __('applications.index'))

@section('content')
    <x-container>
        <x-card class="p-6 dark:text-gray-200">
            <div class="flex flex-wrap mb-4 gap-4">
                @foreach (App\Enums\CharacterStatus::cases() as $_status)
                    <a href="{{ route('applications.index', [ 'status' => $_status ]) }}"
                       class="{{ $status == $_status ?:"opacity-40" }}">
                        <x-character.status :status=$_status />
                    </a>
                @endforeach

                <x-search-field class="w-full" :search="$search" :route="route('applications.index')"/>
            </div>

            @if(count($characters))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            @sortablelink('name', __('label.name'))
                        </x-table.header>

                        <x-table.header>
                            @sortablelink('user.login', __('label.player'))
                        </x-table.header>

                        @unless($status == App\Enums\CharacterStatus::Blank || $status == App\Enums\CharacterStatus::Pending)
                            <x-table.header>
                                @sortablelink('registrar.name', __('label.registrar'))
                            </x-table.header>
                        @endunless

                        @unless(isset($status))
                            <x-table.header>
                                @sortablelink('status', __('label.status'))
                            </x-table.header>
                        @endunless

                        <x-table.header>
                            @sortablelink('status_updated_at', __('label.waiting'))
                        </x-table.header>

                        <x-table.header>
                            {{ __('label.actions') }}
                        </x-table.header>
                    </x-slot>

                    @foreach ($characters as $character)
                        <x-table.row>
                            <x-table.cell>
                                <x-link href="{{ route('characters.show', $character->login) }}">
                                    {{ $character->name }}
                                </x-link>
                            </x-table.cell>

                            <x-table.cell>
                                <x-link href="{{ route('users.show', $character->user) }}">
                                    {{ $character->user->login }}
                                </x-link>
                            </x-table.cell>

                            @unless($status == App\Enums\CharacterStatus::Blank || $status == App\Enums\CharacterStatus::Pending)
                                <x-table.cell>
                                    {{ $character->registrar ? $character->registrar->login : "" }}
                                </x-table.cell>
                            @endunless

                            @unless(isset($status))
                                <x-table.cell>
                                    <x-character.status :status="$character->status"/>
                                </x-table.cell>
                            @endunless

                            <x-table.cell title="{{ $character->status_updated_at }}">
                                {{ Carbon\Carbon::parse($character->status_updated_at)->diffForHumans() }}
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex flex-wrap justify-center">
                                    <x-application.actions :character="$character" :icons="true"/>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>
            @else
                <x-text-bg>
                    {{ __('characters.empty') }}
                </x-text-bg>
            @endif

            <div class="pt-4">
                {{ $characters->appends(request()->query())->links() }}
            </div>
        </x-card>
    </x-container>
@endsection
