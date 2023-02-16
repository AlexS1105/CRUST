@extends('layouts.app')

@section('header', __('skills.index'))

@section('content')
    <x-container>
        <x-card class="space-y-4">
            <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600" href="{{ route('skills.create') }}">
                <div class="far fa-plus-square text-xl"></div>

                <div class="text-lg">
                    {{ __('skills.create') }}
                </div>
            </a>

            @if ($skills->isNotEmpty())
                @foreach ($skills as $skill)
                    <x-skill :skill="$skill">
                        <x-slot name="name">
                            <a class="fas fa-edit text-xl text-gray-600"
                               href="{{ route('skills.edit', $skill) }}"></a>

                            <form method="POST" action="{{ route('skills.destroy', $skill) }}">
                                @method('DELETE')
                                @csrf

                                <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                                   onclick="event.preventDefault();this.closest('form').submit();"></a>
                            </form>
                        </x-slot>
                    </x-skill>
                @endforeach
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('skills.empty') }}
                </div>
            @endif
        </x-card>
    </x-container>
@endsection
