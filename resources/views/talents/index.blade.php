@extends('layouts.app')

@section('header', __('talents.index'))

@section('content')
    <x-container>
        <x-card class="space-y-4">
            <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600 dark:text-gray-300" href="{{ route('talents.create') }}">
                <div class="far fa-plus-square text-xl"></div>

                <div class="text-lg">
                    {{ __('talents.create') }}
                </div>
            </a>

            @if ($talents->isNotEmpty())
                @foreach ($talents as $talent)
                    <x-talent-card :talent="$talent" :accordion="false">
                        <x-slot name="name">
                            <a class="fas fa-edit text-xl text-gray-600 dark:text-gray-300"
                               href="{{ route('talents.edit', $talent) }}"></a>

                            <form method="POST" action="{{ route('talents.destroy', $talent) }}">
                                @method('DELETE')
                                @csrf

                                <a class="fas fa-trash cursor-pointer text-xl text-gray-600 dark:text-gray-300"
                                   onclick="event.preventDefault();this.closest('form').submit();"></a>
                            </form>
                        </x-slot>
                    </x-talent-card>
                @endforeach
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('talents.empty') }}
                </div>
            @endif
        </x-card>
    </x-container>
@endsection
