@extends('layouts.app')

@section('header', __('techniques.index'))

@section('content')
    <x-container>
        <x-card class="space-y-4">
            <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600" href="{{ route('techniques.create') }}">
                <div class="far fa-plus-square text-xl"></div>

                <div class="text-lg">
                    {{ __('techniques.create') }}
                </div>
            </a>

            @if ($techniques->isNotEmpty())
                @foreach ($techniques as $technique)
                    <x-technique-card :technique="$technique" :accordion="false">
                        <x-slot name="name">
                            <a class="fas fa-edit text-xl text-gray-600"
                               href="{{ route('techniques.edit', $technique) }}"></a>

                            <form method="POST" action="{{ route('techniques.destroy', $technique) }}">
                                @method('DELETE')
                                @csrf

                                <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                                   onclick="event.preventDefault();this.closest('form').submit();"></a>
                            </form>
                        </x-slot>
                    </x-technique-card>
                @endforeach
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('techniques.empty') }}
                </div>
            @endif
        </x-card>
    </x-container>
@endsection
