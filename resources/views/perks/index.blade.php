@extends('layouts.app')

@section('header', __('perks.index'))

@section('content')
    <x-container>
        <x-card class="space-y-4">
            <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600" href="{{ route('perks.create') }}">
                <div class="far fa-plus-square text-xl"></div>

                <div class="text-lg">
                    {{ __('perks.create') }}
                </div>
            </a>

            @if (count($perks))
                @foreach ($perks as $perk)
                    <div class="border border-gray-400 rounded-xl overflow-hidden">
                        <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                            <div class="flex items-center font-bold text-lg uppercase space-x-2">
                                <div class="p-2 text-center border-r border-gray-400">
                                    {{ $perk->cost }}
                                </div>
                                <div class="p-2 text-lg uppercase">
                                    {{ $perk->name }}
                                </div>
                                <a class="fas fa-edit text-xl text-gray-600"
                                   href="{{ route('perks.edit', $perk) }}"></a>

                                <form method="POST" action="{{ route('perks.destroy', $perk) }}">
                                    @method('DELETE')
                                    @csrf

                                    <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                                       onclick="event.preventDefault();this.closest('form').submit();"></a>
                                </form>
                            </div>
                        </div>
                        <div class="divide-y divide-dashed">
                            @if (isset($perk->description))
                                <div class="flex items-center p-2 space-x-2 justify-between">
                                    <x-markdown>{!! $perk->description !!}</x-markdown>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{ $perks->links() }}
            @else
                <div class="my-4 text-xl font-semibold text-gray-500 text-center">
                    {{ __('perks.empty') }}
                </div>
            @endif
        </x-card>
    </x-container>
@endsection
