@php use App\Enums\PerkType; @endphp
@extends('layouts.base')

@section('body')
<div class="z-10 p-2 fixed top-0 w-full bg-white border-b">
    <div class="flex p-1 mb-2 space-x-2">
        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Combat]) }}"
           class="bg-red-200 px-2 rounded-full {{ isset($perkType) && App\Enums\PerkType::on($perkType, App\Enums\PerkType::Combat) ? '' : 'opacity-50' }}">
            {{ __('perks.types.combat') }}
        </a>

        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::None]) }}"
           class="bg-green-200 px-2 rounded-full {{ isset($perkType) && $perkType == 0 ? '' : 'opacity-50' }}">
            {{ __('perks.types.noncombat') }}
        </a>

        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Attack]) }}"
           class="bg-orange-200 px-2 rounded-full {{ isset($perkType) && App\Enums\PerkType::on($perkType, App\Enums\PerkType::Attack) ? '' : 'opacity-50' }}">
            {{ __('perks.types.attack') }}
        </a>

        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Defence]) }}"
           class="bg-blue-300 px-2 rounded-full {{ isset($perkType) && App\Enums\PerkType::on($perkType, App\Enums\PerkType::Defence) ? '' : 'opacity-50' }}">
            {{ __('perks.types.defence') }}
        </a>

        <a href="{{ route('perks.list') }}" class="bg-gray-200 px-2 rounded-full">
            ✕
        </a>
    </div>

    <x-search-field :search="$search" :route="route('perks.list')"/>
</div>

    <div class="mt-24"></div>

    <div class="p-6 space-y-4">
        @if (count($perks))
            @foreach ($perks as $perk)
                <div class="border border-gray-400 rounded-xl overflow-hidden">
                    <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                        <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-2">
                            {{ $perk->name }}
                        </div>
                    </div>
                    <div class="flex bg-gray-50 border-b border-gray-400 px-2 py-1 space-x-2 uppercase font-bold text-sm  ">
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
                            <x-markdown class="p-2 min-w-full border-b">{!! $perk->general_description !!}</x-markdown>
                        @endif

                        @foreach ($perk->variants as $perkVariant)
                            <x-markdown class="p-2 min-w-full {{ isset($perk->general_description) ? 'bg-gray-50' : '' }}">{!! $perkVariant->description !!}</x-markdown>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                {{ __('perks.empty') }}
            </p>
        @endif

        {{ $perks->appends(request()->query())->links() }}
    </div>
@endsection
