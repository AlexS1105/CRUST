@extends('layouts.app')

@section('title', $character->name)

@section('header')
    <div class="lg:flex lg:justify-between lg:items-center text-gray-600">
        <div class="text-center text-lg md:text-left">
            <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                {{ $character->name }}
            </h2>

            @can('see-player-only-info', $character)
                <div class="font-thin text-base">
                    {{ __('label.player') }}:
                    <a
                        @can('view', $character->user)
                            class="font-bold underline text-blue-600 visited:text-purple-600"
                            href="{{ route('users.show', $character->user) }}"
                        @endcan
                    >
                        {{ $character->user->login }}
                    </a>
                </div>

                <div class="font-thin text-base">
                    Discord: <span class="select-all">{{ $character->user->discord_tag }}</span>
                </div>
            @endcan

            <div class="font-thin text-base">
                {{ __('label.login') }}: <span class="select-all">{{ $character->login }}</span>
            </div>
        </div>

        <div class="flex flex-wrap justify-center">
            <x-application.actions :character="$character" :icons="false"/>
        </div>

        <div>
            <div class="flex justify-center items-center gap-4 font-bold text-xl text-center mt-2 sm:mt-0">
                <div class="hidden sm:block">{{ __('label.status') }}:</div>

                <x-character.status :status="$character->status"/>
            </div>
            @if ($character->registrar)
                <div class="font-thin text-base text-right mt-2">
                    {{ __('label.registrar') }}:
                    {{ $character->registrar->discord_tag }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <x-container class="max-w-6xl space-y-8">
        <div class="flex flex-wrap md:flex-nowrap justify-center gap-8 p-2 md:p-0">
            <x-card class="max-w-md my-auto flex-none p-0">
                <img
                    class="object-cover"
                    src="{{ Storage::disk('characters')->url($character->reference) }}"
                    alt="Character Reference"
                />
            </x-card>

            <div class="space-y-8 my-auto">
                @can('see-main-info', $character)
                    <x-card class="mr-auto text-justify">
                        <x-header>
                            {{ __('characters.cards.main_info') }}
                        </x-header>

                        <div class="text-lg">
                            <div>
                                <b>{{ __('label.origin') }}:</b> {{ $character->origin->localized() }}
                            </div>

                            <div>
                                <b>{{ __('label.race') }}:</b> {{ $character->race }}
                            </div>

                            <div>
                                <b>{{ __('label.age') }}:</b> {{ $character->age }}
                            </div>

                            <div>
                                <b>{{ __('label.legacy') }}:</b> {{ $character->legacy }}
                            </div>
                        </div>
                    </x-card>
                @endcan

                @can('see-main-info', $character)
                    <x-card class="mr-auto text-justify">
                        <x-header>
                            {{ __('label.description') }}
                        </x-header>

                        <x-markdown class="max-w-none">{!! $character->description !!}</x-markdown>
                    </x-card>
                @endcan

                @if ($character->appearance)
                    <x-card>
                        <x-header>
                            {{ __('label.appearance') }}
                        </x-header>

                        <x-markdown class="max-w-none">{!! $character->appearance !!}</x-markdown>

                        @can('see-player-only-info', $character)
                            <x-link href="{{ route('characters.skins.index', $character) }}">
                                {{ __('skins.index') }}
                            </x-link>
                        @endcan
                    </x-card>
                @endif

                @can('see-player-only-info', $character)
                    <x-card class=" max-w-max mx-auto">
                        <x-header class="max-w-max mx-auto">
                            {{ __('label.estitence') }}: {{ $character->estitence }}
                        </x-header>

                        <div class="space-x-2">
                            @can('estitence-view', $character)
                                <x-link href="{{ route('characters.estitence.index', $character) }}">
                                    {{ __('estitence.index') }}
                                </x-link>
                            @endcan

                            @can('estitence-create', $character)
                                <x-link href="{{ route('characters.estitence.create', $character) }}">
                                    {{ __('estitence.create') }}
                                </x-link>
                            @endcan
                        </div>
                    </x-card>
                @endcan
            </div>
        </div>

        @can('see-player-only-info', $character)
            @if(isset($character->charsheet->stats) || $character->skills->isNotEmpty())
                <div class="md:flex justify-center md:gap-8 md:space-y-0 space-y-4 items-center">
                    @if(isset($character->charsheet->stats) && count($character->charsheet->stats))
                        <x-card class="w-full my-auto">
                            <x-header>
                                {{ __('charsheet.stats') }} ({{ $character->charsheet->stats_sum }} / {{ $character->stats_handled ? '???' : $character->estitence }})
                            </x-header>

                            @php
                                $inequality = $character->stats_inequality;
                                $positive = $inequality > 0;
                            @endphp

                            @if($inequality != 0 && ! $character->stats_handled)
                                <div class="mb-3 font-bold text-center {{ $positive ? 'text-green-600' : 'text-red-600'}}">
                                    {{ __('charsheet.inequality.' . ($positive ? 'positive' : 'negative'), ['inequality' => abs($inequality)]) }}
                                </div>
                            @endif

                            <x-character.charsheet.stats>
                                <x-slot name="headerBody">
                                    ({{ $character->charsheet->body_sum }})
                                </x-slot>
                                <x-slot name="headerEssence">
                                    ({{ $character->charsheet->essence_sum }})
                                </x-slot>

                                @foreach ($character->charsheet->stats as $stat => $value)
                                    <x-slot :name="$stat">
                                        {{ $value }}
                                    </x-slot>
                                @endforeach
                            </x-character.charsheet.stats>

                            @can('update-stats', $character)
                                <x-accordion-action class="my-2 w-full border-t"
                                                    method="GET"
                                                    action="{{ route('characters.stats.update', ['character' => $character]) }}"
                                                    icon="fa-solid fa-arrows-turn-to-dots"
                                >
                                    {{ __('stat.update') }}
                                </x-accordion-action>
                            @endcan

                        </x-card>
                    @endif

                    @if ($character->skills->isNotEmpty())
                        <x-card class="w-full my-auto">
                            <x-header>
                                {{ __('skills.index') }} ({{ $character->skill_sum }} / {{ $character->skill_points }})
                            </x-header>

                            <div id="skills-open" data-accordion="open">
                                @foreach ($character->skills as $skill)
                                    <x-accordion-item id="skill" :loop="$loop">
                                        <x-slot name="title">
                                            {{ $skill->name }} ({{ $skill->pivot->bonus }})
                                        </x-slot>

                                        <x-slot name="body">
                                            <x-skill-bar class="border-gray-200" :skill="$skill" />

                                            <ul class="py-0.5 px-1 bg-gray-50 border-b border-gray-200 text-sm">
                                                <span>
                                                    {{ __('skills.level.title') }}:
                                                    <b>
                                                        {{ __('skills.level.' . $skill->pivot->level) }}
                                                    </b>
                                                    ({{ $skill->pivot->cost }})
                                                </span>
                                                <hr class="my-1">
                                                <div>
                                                    {{ $skill->stat->localized() }}:
                                                    <b>+{{ $character->charsheet->skills[$skill->stat->value] }}</b>
                                                </div>
                                                @if($skill->pivot->level >= 2)
                                                    <div>
                                                        {{ __('skills.soul_coefficient') }}:
                                                        <b>+{{ $character->soul_coefficient }}</b>
                                                    </div>
                                                @endif

                                                @if($skill->pivot->level == 1 || $skill->pivot->level == 3)
                                                    <div>
                                                        {{ __('skills.level.bonus') }}:
                                                        <b>+{{ $skill->pivot->level }}</b>
                                                    </div>
                                                @endif
                                            </ul>
                                        </x-slot>

                                        <x-slot name="content">
                                            {{ $skill->description }}
                                        </x-slot>
                                    </x-accordion-item>
                                @endforeach
                            </div>

                            @can('update-charsheet-gm', $character)
                                <x-accordion-action class="my-2 w-full border-t"
                                                    method="GET"
                                                    action="{{ route('characters.skills.update', ['character' => $character]) }}"
                                                    icon="fa-solid fa-arrows-turn-to-dots"
                                >
                                    {{ __('skills.update') }}
                                </x-accordion-action>
                            @endcan
                        </x-card>
                    @endif
                </div>
            @endif
        @endcan

        @can('see-player-only-info', $character)
            @if ($character->perks->isNotEmpty())
                <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('perks.index') }}
                            ({{ $character->perk_sum }} / {{ $character->perk_points }} {{ __('perks.points') }})
                            ({{ $character->perks->count() }} / {{ app(App\Settings\CharsheetSettings::class)->max_perks }} {{ __('perks.slots') }})
                        </x-header>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($character->perks->sortByDesc('name') as $perk)
                                <x-perk-card class="h-min" :character="$character" :perk="$perk" :accordion="true" />
                            @endforeach
                        </div>
                    </x-card>
                </div>
            @endif

            @can('update-charsheet-gm', $character)
                <x-character.action href="{{ route('characters.perks.edit', $character) }}">
                    {{ __('charsheet.edit.perks') }}
                </x-character.action>
            @endcan

            @if ($character->talents->isNotEmpty())
                <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('talents.index') }}
                            ({{ $character->talent_sum }} / {{ $character->talent_points }} {{ __('talents.points') }})
                            ({{ $character->talents->count() }} / {{ $character->max_talent_amount }} {{ __('talents.slots') }})
                        </x-header>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($character->talents->sortByDesc('name') as $talent)
                                <x-talent-card class="h-min" :character="$character" :talent="$talent" :accordion="true" />
                            @endforeach
                        </div>
                    </x-card>
                </div>
            @endif

            @can('update-charsheet-gm', $character)
                <x-character.action href="{{ route('characters.talents.edit', $character) }}">
                    {{ __('talents.update') }}
                </x-character.action>
            @endcan
        @endcan

        @can('see-player-only-info', $character)
            @if (count($character->tides))
                <x-card class=" mx-auto w-max max-w-full">
                    <x-header>
                        {{ __('tides.index') }}
                    </x-header>

                    <x-character.tides>
                        @foreach($character->tides as $tide)
                            <x-slot :name="'level_' . $tide->tide->value">
                                {{ $tide->level }}
                            </x-slot>

                            <x-slot :name="'content_' . $tide->tide->value">
                                {{ $tide->path }}
                            </x-slot>
                        @endforeach
                    </x-character.tides>
                </x-card>
            @endif
        @endcan

        @can('update-charsheet-gm', $character)
            <x-character.action href="{{ route('characters.tides.edit', $character) }}">
                {{ __('tides.update') }}
            </x-character.action>
        @endcan

        @can('see-player-only-info', $character)
            @if ($character->player_only_info)
                <x-card>
                    <x-header>
                        {{ __('label.player_only_info') }}
                    </x-header>

                    <x-markdown class="max-w-none">{!! $character->player_only_info !!}</x-markdown>
                </x-card>
            @endif
        @endcan

        @if ($character->gm_only_info)
            @can('see-gm-only-info', $character)
                <x-card>
                    <x-header>
                        {{ __('label.gm_only_info') }}
                    </x-header>

                    <x-markdown class="max-w-none">{!! $character->gm_only_info !!}</x-markdown>
                </x-card>
            @endcan
        @endif

        @can('see-bio', $character)
            @if ($character->personality)
                <x-card>
                    <x-header>
                        {{ __('label.personality') }}
                    </x-header>

                    <x-markdown class="max-w-none">{!! $character->personality !!}</x-markdown>
                </x-card>
            @endif
            @if ($character->background)
                <x-card>
                    <x-header>
                        {{ __('label.background') }}
                    </x-header>

                    <x-markdown class="max-w-none">{!! $character->background !!}</x-markdown>
                </x-card>
            @endif
        @endcan
    </x-container>
@endsection
