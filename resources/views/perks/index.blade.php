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
                            <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-2">
                                <div>
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
                        <div
                            class="flex bg-gray-50 border-b border-gray-400 px-2 py-1 space-x-2 uppercase font-bold text-sm  ">
                            @if ($perk->isCombat())
                                <div class="bg-red-100 px-2 rounded-full">
                                    {{ __('perks.types.combat') }}
                                </div>
                            @else
                                <div class="bg-green-100 px-2 rounded-full">
                                    {{ __('perks.types.noncombat') }}
                                </div>
                            @endif

                            @if ($perk->isAttack())
                                <div class="bg-orange-100 px-2 rounded-full">
                                    {{ __('perks.types.attack') }}
                                </div>
                            @endif

                            @if ($perk->isDefence())
                                <div class="bg-blue-200 px-2 rounded-full">
                                    {{ __('perks.types.defence') }}
                                </div>
                            @endif
                        </div>
                        <div class="divide-y divide-dashed">
                            @if (isset($perk->general_description))
                                <div class="flex items-center p-2 space-x-2 justify-between">
                                    <x-markdown class="border-b">{!! $perk->general_description !!}</x-markdown>
                                </div>
                            @endif
                            @foreach ($perk->variants as $perkVariant)
                                <div
                                    class="flex items-center p-2 space-x-2 justify-between {{isset($perk->general_description) ? "bg-gray-50" : ""}}">
                                    <x-markdown>{!! $perkVariant->description !!}</x-markdown>
                                    <div class="flex space-x-2">
                                        <a class="fas fa-edit text-xl text-gray-600"
                                           href="{{ route('perks.variants.edit', ['variant' => $perkVariant->id, 'perk' => $perk]) }}"></a>

                                        <form method="POST"
                                              action="{{ route('perks.variants.destroy', ['variant' => $perkVariant->id, 'perk' => $perk]) }}">
                                            @method('DELETE')
                                            @csrf

                                            <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                                               onclick="event.preventDefault();this.closest('form').submit();"></a>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <div clas="min-w-max">
                                <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600 p-2"
                                   href="{{ route('perks.variants.create', $perk) }}">
                                    <div class="far fa-plus-square text-xl"></div>
                                    <div class="text-lg">
                                        {{ __('perks.variants.create') }}
                                    </div>
                                </a>
                            </div>
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
