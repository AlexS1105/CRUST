@extends('layouts.app')

@section('header', __('accounts.index'))

@section('content')
    <x-container class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-6 w-auto">
            <x-link
               href="{{ route('users.accounts.create', $user) }}">
                {{ __('accounts.create') }}
            </x-link>
            @if(count($user->accounts))
                <table class="table-auto w-full border">
                    <thead class="border bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.account') }}
                        </th>
                        <th class="px-4 py-2 border border-gray-400">
                            {{ __('label.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($user->accounts as $account)
                        <tr class="py-2 border hover:bg-gray-100">
                            <td class="px-4 py-2 border">
                                {{ $account->login }}
                            </td>
                            <td class="border">
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('accounts.empty') }}
                </p>
            @endif
        </div>
    </x-container>
@endsection
