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
                    <div class="border border-gray-400 rounded-xl overflow-hidden">
                        <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                            <div class="flex items-center font-bold text-lg uppercase space-x-2">
                                <div class="p-2 text-lg uppercase flex gap-2 items-center">
                                    {{ $skill->name }}
                                </div>
                                <a class="fas fa-edit text-xl text-gray-600"
                                   href="{{ route('skills.edit', $skill) }}"></a>

                                <form method="POST" action="{{ route('skills.destroy', $skill) }}">
                                    @method('DELETE')
                                    @csrf

                                    <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                                       onclick="event.preventDefault();this.closest('form').submit();"></a>
                                </form>
                            </div>
                        </div>
                        <div class="flex font-bold gap-1 p-0.5 border-b bg-gray-50 border-gray-400">
                            <div class="text-xs bg-{{ $skill->stat->color() }} py-0.5 px-1 rounded-full">
                                {{ $skill->stat->localized() }}
                            </div>

                            @if($skill->proficiency)
                                <div class="text-xs bg-yellow-100 py-0.5 px-1 rounded-full">
                                    {{ __('skills.proficiency') }}
                                </div>
                            @endif
                        </div>
                        <div class="divide-y divide-dashed">
                            @if (isset($skill->description))
                                <div class="flex items-center p-2 space-x-2 justify-between">
                                    {{ $skill->description }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('skills.empty') }}
                </div>
            @endif
        </x-card>
    </x-container>
@endsection
