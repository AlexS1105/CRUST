@extends('layouts.app')

@section('header', __('accounts.index'))

@section('content')
    <x-container class="max-w-2xl">
        <x-card>
            <x-link
               href="{{ route('users.accounts.create', $user) }}">
                {{ __('accounts.create') }}
            </x-link>
            @if(count($user->accounts))
                <x-table>
                    <x-slot name="heading">
                        <x-table.header>
                            {{ __('label.account') }}
                        </x-table.header>
                        <x-table.header>
                            {{ __('label.actions') }}
                        </x-table.header>
                    </x-slot>
                    @foreach ($user->accounts as $account)
                        <x-table.row>
                            <x-table.cell>
                                {{ $account->login }}
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex w-min mx-auto space-x-2">
                                    <form method="POST"
                                          action="{{ route('users.accounts.destroy', ['user' => $user, 'account' => $account]) }}">
                                        @method('DELETE')
                                        @csrf

                                        <x-link
                                            onclick="event.preventDefault();this.closest('form').submit();"
                                        >
                                            {{ __('accounts.delete') }}
                                        </x-link>
                                    </form>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 dark:text-gray-300 text-center">
                    {{ __('accounts.empty') }}
                </p>
            @endif
        </x-card>
    </x-container>
@endsection
