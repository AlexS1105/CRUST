<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased bg-white">
<div class="z-10 p-2 fixed top-0 w-full bg-white border-b">
    @php
        $perkTypeInstance = isset($perkType) ? App\Enums\PerkType::from($perkType) : App\Enums\PerkType::None;
    @endphp
    <div class="flex p-1 mb-2 space-x-2">
        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Combat]) }}"
           class="bg-red-200 px-2 rounded-full {{ $perkTypeInstance->isCombat() ? '' : 'opacity-50' }}">
            {{ __('perks.types.combat') }}
        </a>
        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::None]) }}"
           class="bg-green-200 px-2 rounded-full {{ isset($perkType) && $perkTypeInstance->value == App\Enums\PerkType::None ? '' : 'opacity-50' }}">
            {{ __('perks.types.noncombat') }}
        </a>
        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Attack]) }}"
           class="bg-orange-200 px-2 rounded-full {{ $perkTypeInstance->hasFlag(App\Enums\PerkType::Attack) ? '' : 'opacity-50' }}">
            {{ __('perks.types.attack') }}
        </a>
        <a href="{{ route('perks.list', ['perk_type' => App\Enums\PerkType::Defence]) }}"
           class="bg-blue-300 px-2 rounded-full {{ $perkTypeInstance->hasFlag(App\Enums\PerkType::Defence) ? '' : 'opacity-50' }}">
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
                        <div class="prose markdown p-2 min-w-full border-b">{!! $perk->general_description !!}</div>
                    @endif
                    @foreach ($perk->variants as $perkVariant)
                        <div
                            class="prose markdown p-2 min-w-full {{isset($perk->general_description) ? "bg-gray-50" : ""}}">{!! $perkVariant->description !!}</div>
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
</body>
</html>
