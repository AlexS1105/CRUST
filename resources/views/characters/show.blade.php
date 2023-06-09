@php use App\Enums\CharacterStat;use App\Models\Rumor; @endphp
@extends('layouts.app')

@section('title', $character->name)

@section('header')
    <div class="lg:flex lg:justify-between lg:items-center text-gray-600 dark:text-gray-200">
        <div class="text-center text-lg lg:text-left">
            <h2 class="font-semibold leading-tight text-gray-800 dark:text-gray-100 text-3xl">
                {{ $character->name }}
            </h2>

            @can('see-player-only-info', $character)
                <div class="font-thin text-base">
                    {{ __('label.player') }}:
                    <x-user-link :user="$character->user"/>
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
    <x-container class="max-w-6xl space-y-8 dark:text-gray-100">
        <div class="flex flex-wrap lg:flex-nowrap justify-center gap-8 p-2 lg:p-0">
            <x-card class="lg:max-w-md max-w-fit my-auto flex-none p-0">
                <img
                    class="object-cover rounded-xl dark:bg-white"
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
                            @can('see-player-only-info', $character)
                                <div>
                                    <b>{{ __('label.origin') }}:</b> {{ $character->origin->localized() }}
                                </div>
                            @endcan

                            <div>
                                <b>{{ __('label.race') }}:</b> {{ $character->race }}
                            </div>

                            <div>
                                <b>{{ __('label.age') }}:</b> {{ $character->age }}
                            </div>

                            @can('see-player-only-info', $character)
                                <div>
                                    <b>{{ __('label.legacy') }}:</b> {{ $character->legacy }}
                                </div>
                            @endcan
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
                    <div class="md:flex justify-center md:gap-8 md:space-y-0 space-y-4 items-center">
                        <x-card class="max-w-max mx-auto">
                            <x-header class="max-w-max mx-auto">
                                {{ __('label.estitence') }}: {{ $character->estitence }}
                            </x-header>

                            @if(!$character->estitence_reduce)
                                <div class="my-2 text-xs text-green-500 dark:text-green-400 dark:drop-shadow-xs">
                                    {{ __('characters.no_estitence_reduce') }}
                                </div>
                            @endif

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

                        <x-card class="max-w-max mx-auto">
                            <x-header class="max-w-max mx-auto">
                                {{ __('label.experience') }}: {{ $character->experience }}
                            </x-header>

                            <div class="space-x-2">
                                @can('update-charsheet-gm', $character)
                                    <x-link href="{{ route('characters.experience.edit', $character) }}">
                                        {{ __('experience.edit') }}
                                    </x-link>
                                @endcan
                            </div>
                        </x-card>
                    </div>
                @endcan
            </div>
        </div>

        @can('see-player-only-info', $character)
            @if(isset($character->charsheet->stats) && count($character->charsheet->stats))
                <x-card class="w-full my-auto">
                    <x-header>
                        {{ __('charsheet.stats') }} ({{ $character->charsheet->stats_sum }}
                        / {{ $character->stats_handled ? '???' : $character->estitence }})
                    </x-header>

                    @php
                        $inequality = $character->stats_inequality;
                        $positive = $inequality > 0;
                    @endphp

                    @if($inequality != 0 && ! $character->stats_handled)
                        <div class="mb-3 font-bold text-center dark:drop-shadow-xs {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}}">
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

            <x-card class="w-full my-auto">
                <x-header>
                    {{ __('skills.index') }} ({{ $character->skill_sum }} / {{ $character->skill_points }})
                </x-header>

                <div id="skills-open" data-active-classes="rounded-t-xl" data-inactive-classes="rounded-xl" data-accordion="open" class="flex gap-4">
                    <div class="w-1/2 space-y-1">
                        @foreach (CharacterStat::getBodyStats() as $stat)
                            @continue(!$skills->has($stat->value))

                            <div class="p-2 border border-2 border-{{ $stat->color() }}-400 dark:border-{{ $stat->color() }}-600 rounded-xl">
                                <div class="bg-{{ $stat->color() }}-200 dark:bg-{{ $stat->color() }}-400 rounded-xl text-center text-lg font-bold">
                                    <div class="dark:drop-shadow-xs">
                                        {{ $stat->localized() }}
                                    </div>
                                </div>

                                @foreach ($skills[$stat->value] as $skill)
                                    <x-character.skill :character="$character" :skill="$skill" :loop="$loop"></x-character.skill>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="w-1/2 space-y-1">
                        @foreach (CharacterStat::getEssenceStats() as $stat)
                            @continue(!$skills->has($stat->value))

                            <div class="p-2 border border-2 border-{{ $stat->color() }}-400 dark:border-{{ $stat->color() }}-600 rounded-xl">
                                <div class="bg-{{ $stat->color() }}-200 dark:bg-{{ $stat->color() }}-400 rounded-xl text-center text-lg font-bold">
                                    <div class="dark:drop-shadow-xs">
                                        {{ $stat->localized() }}
                                    </div>
                                </div>

                                @foreach ($skills[$stat->value] as $skill)
                                    <x-character.skill :character="$character" :skill="$skill" :loop="$loop"></x-character.skill>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
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
        @endcan

        @can('see-player-only-info', $character)
            @if ($character->perks->isNotEmpty())
                <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('perks.index') }}
                            ({{ $character->perk_sum }} / {{ $character->perk_points }} {{ __('perks.points') }})
                            ({{ $character->perks->count() }}
                            / {{ app(App\Settings\CharsheetSettings::class)->max_perks }} {{ __('perks.slots') }})
                        </x-header>

                        <div class="md:grid md:grid-cols-2 md:gap-4 md:space-y-0 space-y-4">
                            @foreach ($character->perks->sortByDesc('name') as $perk)
                                <x-perk-card class="h-min" :character="$character" :perk="$perk" :accordion="true"/>
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
                            ({{ $character->talents->count() }}
                            / {{ $character->max_talent_amount }} {{ __('talents.slots') }})
                        </x-header>

                        <div class="md:grid md:grid-cols-2 md:gap-4 md:space-y-0 space-y-4">
                            @foreach ($character->talents->sortByDesc('name') as $talent)
                                <x-talent-card class="h-min" :character="$character" :talent="$talent"
                                               :accordion="true"/>
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


            @if ($character->techniques->isNotEmpty())
                <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('techniques.index') }}
                            ({{ $character->technique_sum }}
                            / {{ $character->technique_points }} {{ __('techniques.points') }})
                            ({{ $character->techniques->count() }}
                            / {{ $character->max_technique_amount }} {{ __('techniques.slots') }})
                        </x-header>

                        <div class="md:grid md:grid-cols-2 md:gap-4 md:space-y-0 space-y-4">
                            @foreach ($character->techniques->sortByDesc('name') as $technique)
                                <x-technique-card class="h-min" :character="$character" :technique="$technique"
                                                  :accordion="true"/>
                            @endforeach
                        </div>
                    </x-card>
                </div>
            @endif

            @can('update-charsheet-gm', $character)
                <x-character.action href="{{ route('characters.techniques.edit', $character) }}">
                    {{ __('techniques.update') }}
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

                            @isset($tide->path)
                                <x-slot :name="'content_' . $tide->tide->value">
                                    {{ $tide->path }}
                                </x-slot>
                            @endisset
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

        @if($character->rumors()->actual()->count() > 0 || auth()->user()->can('create', [App\Models\Rumor::class, $character]))
            <x-card>
                <x-header>
                    {{ __('rumors.index') }}
                </x-header>

                @can('create', [App\Models\Rumor::class, $character])
                    <a class="mb-2 flex max-w-fit space-x-2 items-center font-bold text-gray-600 dark:text-gray-200"
                       href="{{ route('characters.rumors.create', $character->login) }}">
                        <div class="far fa-comment-dots text-xl"></div>

                        <div class="text-lg">
                            {{ __('rumors.create') }}
                        </div>
                    </a>
                @endcan

                <div class="space-y-2">
                    @foreach($character->rumors()->actual()->latest()->get() as $rumor)
                        <x-rumor :rumor="$rumor"/>
                    @endforeach
                </div>

                <a class="text-lg mt-2 flex max-w-fit space-x-2 items-center font-bold text-gray-600 dark:text-gray-200"
                   href="{{ route('rumors.character', $character) }}">
                    {{ __('rumors.character') }}
                </a>
            </x-card>
        @endif

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
