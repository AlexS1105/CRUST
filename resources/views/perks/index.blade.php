@extends('layouts.app')

@section('header', __('perks.index'))

@section('content')
    <x-container>
        <x-card class="space-y-4">
            <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600 dark:text-gray-300" href="{{ route('perks.create') }}">
                <div class="far fa-plus-square text-xl"></div>

                <div class="text-lg">
                    {{ __('perks.create') }}
                </div>
            </a>

            @if ($perks->isNotEmpty())
                @foreach ($perks as $perk)
                    <x-perk-card :perk="$perk" :accordion="false">
                        <x-slot name="name">
                            <a class="fas fa-edit text-xl text-gray-600 dark:text-gray-300"
                               href="{{ route('perks.edit', $perk) }}"></a>

                            <form method="POST" action="{{ route('perks.destroy', $perk) }}">
                                @method('DELETE')
                                @csrf

                                <a class="fas fa-trash cursor-pointer text-xl text-gray-600 dark:text-gray-300"
                                   onclick="event.preventDefault();this.closest('form').submit();"></a>
                            </form>
                        </x-slot>
                    </x-perk-card>
                @endforeach
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('perks.empty') }}
                </div>
            @endif

            <div class="pt-4">
                {{ $perks->appends(request()->query())->links() }}
            </div>
        </x-card>
    </x-container>
@endsection
