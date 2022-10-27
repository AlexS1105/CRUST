@extends('layouts.app')

@section('title', $character->name)

@section('header')
    <div class="lg:flex lg:justify-between lg:items-center text-gray-600">
        <div class="text-center text-lg md:text-left">
            <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                {{ $character->name }}
            </h2>

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
                            <div class="flex items-center gap-1">
                                <b>{{ __('label.gender') }}:</b>
                                {{ $character->gender->localized() }}
                                <div
                                    class="text-2xl fa {{ $character->gender->icon() }} {{ $character->gender->color() }}"></div>
                            </div>

                            <div>
                                <b>{{ __('label.race') }}:</b> {{ $character->race }}
                            </div>

                            <div>
                                <b>{{ __('label.age') }}:</b> {{ $character->age }}
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
                            {{ __('label.vox') }}: {{ $character->vox }}
                        </x-header>

                        <div class="space-x-2">
                            @can('vox-view', $character)
                                <x-link href="{{ route('characters.vox.index', $character) }}">
                                    {{ __('vox.index') }}
                                </x-link>
                            @endcan

                            @can('vox-create', $character)
                                <x-link href="{{ route('characters.vox.create', $character) }}">
                                    {{ __('vox.create') }}
                                </x-link>
                            @endcan
                        </div>
                    </x-card>
                @endcan
            </div>
        </div>

        @if(isset($character->charsheet->skills) || $character->charsheet->hasAnyCrafts())
            <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                @if(isset($character->charsheet->skills) && count($character->charsheet->skills))
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('charsheet.skills') }}
                        </x-header>

                        <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
                            @foreach ($character->charsheet->skills as $skill => $value)
                                <x-progress value="{{ $value }}">{{ __('skill.'.$skill) }}</x-progress>
                            @endforeach
                        </div>
                    </x-card>
                @endif

                @if ($character->charsheet->hasAnyCrafts())
                    <x-card class="w-full my-auto">
                        <x-header>
                            {{ __('charsheet.crafts.index') }}
                        </x-header>

                        @if($character->charsheet->hasAnyCrafts())
                            <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
                                @foreach ($character->charsheet->crafts as $craft => $value)
                                    @if($value)
                                        <x-progress value="{{ $value }}">{{ __('craft.'.$craft) }}</x-progress>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </x-card>
                @endif
            </div>
        @endif

        @can('see-player-only-info', $character)
            @php
                $narrativeCraftsVisible = Auth::user()->can('update-charsheet-gm', $character) || count($character->narrativeCrafts);
                $experiencesVisible = Auth::user()->can('update-charsheet-gm', $character) || count($character->experiences);
            @endphp

            @if ($narrativeCraftsVisible || $experiencesVisible)
                <div class="flex justify-center gap-8">
                    <x-card class="w-full my-auto">
                        @if($narrativeCraftsVisible)
                            <x-header>
                                {{ __('charsheet.narrative_crafts.title') }}
                            </x-header>

                            <div id="narrative-craft-open" data-accordion="open">
                                @foreach($character->narrativeCrafts as $narrativeCraft)
                                    <x-accordion-item id="narrative-craft" :loop="$loop">
                                        <x-slot name="title">
                                            {{ $narrativeCraft->name }}
                                        </x-slot>

                                        <x-slot name="content">
                                            {{ $narrativeCraft->description }}
                                        </x-slot>

                                        <x-slot name="buttons">
                                            @can('update', $character)
                                                <x-accordion-action method="GET"
                                                    action="{{ route('characters.narrative_crafts.edit', ['character' => $character, 'narrative_craft' => $narrativeCraft]) }}"
                                                    icon="fa-solid fa-pen-to-square"
                                                >
                                                    {{ __('crafts.edit') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="DELETE"
                                                    action="{{ route('characters.narrative_crafts.destroy', ['character' => $character, 'narrative_craft' => $narrativeCraft]) }}"
                                                    icon="fa-solid fa-trash"
                                                    confirm="true"
                                                >
                                                    {{ __('crafts.delete') }}
                                                </x-accordion-action>
                                            @endcan
                                        </x-slot>
                                    </x-accordion-item>
                                @endforeach

                                @can('update-charsheet-gm', $character)
                                    <x-accordion-action class="mt-2 w-full border-t"
                                                        method="GET"
                                                        action="{{ route('characters.narrative_crafts.create', ['character' => $character]) }}"
                                                        icon="fa-solid fa-circle-plus"
                                    >
                                        {{ __('crafts.create') }}
                                    </x-accordion-action>
                                @endcan
                            </div>
                        @endif

                        @if ($narrativeCraftsVisible && $experiencesVisible)
                            <hr class="my-4">
                        @endif

                        @if ($experiencesVisible)
                            <x-header>
                                {{ __('experiences.index') }}
                            </x-header>

                            <div id="experience-open" data-accordion="open">
                                @foreach($character->experiences as $experience)
                                    <x-accordion-item id="experiences" :loop="$loop">
                                        <x-slot name="title">
                                            {{ $experience->name }}
                                        </x-slot>

                                        <x-slot name="content">
                                            {{ $experience->description }}
                                        </x-slot>

                                        <x-slot name="buttons">
                                            @can('update', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.experiences.edit', ['character' => $character, 'experience' => $experience]) }}"
                                                                    icon="fa-solid fa-pen-to-square"
                                                >
                                                    {{ __('experiences.edit') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="DELETE"
                                                                    action="{{ route('characters.experiences.destroy', ['character' => $character, 'experience' => $experience]) }}"
                                                                    icon="fa-solid fa-trash"
                                                                    confirm="true"
                                                >
                                                    {{ __('experiences.delete') }}
                                                </x-accordion-action>
                                            @endcan

                                            @can('update-charsheet-gm', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.experiences.set_view', ['character' => $character, 'experience' => $experience]) }}"
                                                                    icon="fa-solid fa-sliders"
                                                >
                                                    {{ __('experiences.set') }}
                                                </x-accordion-action>
                                            @endcan
                                        </x-slot>
                                    </x-accordion-item>
                                @endforeach

                                @can('update-charsheet-gm', $character)
                                    <x-accordion-action class="mt-2 w-full border-t"
                                                        method="GET"
                                                        action="{{ route('characters.experiences.create', ['character' => $character]) }}"
                                                        icon="fa-solid fa-circle-plus"
                                    >
                                        {{ __('experiences.create') }}
                                    </x-accordion-action>
                                @endcan
                            </div>
                        @endif
                    </x-card>
                </div>
            @endif
        @endcan

        @can('see-player-only-info', $character)
            @php
                $spheresVisible = Auth::user()->can('add-sphere', $character) || count($character->spheres);
                $ideasVisible = Auth::user()->can('add-idea', $character) || count($character->ideas);
            @endphp

            @if ($spheresVisible || $ideasVisible)
                <div class="flex justify-center gap-8">
                    <x-card class="w-full my-auto">
                        @if($spheresVisible)
                            <x-header>
                                {{ __('spheres.index') }}
                            </x-header>

                            <div id="sphere-open" data-accordion="open">
                                @foreach($character->spheres as $sphere)
                                    <x-accordion-item id="sphere" :loop="$loop">
                                        <x-slot name="title">
                                            {{ $sphere->name }}
                                        </x-slot>

                                        <x-slot name="content">
                                            {{ $sphere->description }}
                                        </x-slot>

                                        <x-slot name="buttons">
                                            @can('manage-ideas', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.spheres.edit', ['character' => $character, 'sphere' => $sphere]) }}"
                                                                    icon="fa-solid fa-pen-to-square"
                                                >
                                                    {{ __('spheres.edit') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.spheres.spend', ['character' => $character, 'sphere' => $sphere]) }}"
                                                                    icon="fa-solid fa-arrow-right-to-bracket"
                                                >
                                                    {{ __('spheres.spend') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="DELETE"
                                                                    action="{{ route('characters.spheres.destroy', ['character' => $character, 'sphere' => $sphere]) }}"
                                                                    icon="fa-solid fa-trash"
                                                                    confirm="true"
                                                >
                                                    {{ __('spheres.delete') }}
                                                </x-accordion-action>
                                            @endcan
                                            @can('manage-ideas-gm', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.spheres.add_view', ['character' => $character, 'sphere' => $sphere]) }}"
                                                                    icon="fa-solid fa-circle-plus"
                                                >
                                                    {{ __('spheres.add') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.spheres.experience_view', ['character' => $character, 'sphere' => $sphere]) }}"
                                                                    icon="fa-solid fa-lightbulb"
                                                >
                                                    {{ __('spheres.to_experience') }}
                                                </x-accordion-action>
                                            @endcan
                                        </x-slot>
                                    </x-accordion-item>
                                @endforeach

                                @can('add-sphere', $character)
                                    <x-accordion-action class="mt-2 w-full border-t"
                                                        method="GET"
                                                        action="{{ route('characters.spheres.create', ['character' => $character]) }}"
                                                        icon="fa-solid fa-circle-plus"
                                    >
                                        {{ __('spheres.create') }}
                                    </x-accordion-action>
                                @endcan
                            </div>

                            <x-form.error name="spheres"/>
                        @endif

                        @if ($spheresVisible && $ideasVisible)
                            <hr class="my-4">
                        @endif

                        @if ($ideasVisible)
                            <x-header>
                                {{ __('ideas.index') }}
                            </x-header>
                            <div id="idea-open" data-accordion="open">
                                @foreach($character->ideas as $idea)
                                    <x-accordion-item id="sphere" :loop="$loop">
                                        <x-slot name="title">
                                            {{ $idea->name }}
                                        </x-slot>

                                        <x-slot name="content">
                                            {{ $idea->description }}
                                        </x-slot>

                                        <x-slot name="buttons">
                                            @can('manage-ideas', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.ideas.edit', ['character' => $character, 'idea' => $idea]) }}"
                                                                    icon="fa-solid fa-pen-to-square"
                                                >
                                                    {{ __('ideas.edit') }}
                                                </x-accordion-action>

                                                <x-accordion-action method="DELETE"
                                                                    action="{{ route('characters.ideas.destroy', ['character' => $character, 'idea' => $idea]) }}"
                                                                    icon="fa-solid fa-trash"
                                                                    confirm="true"
                                                >
                                                    {{ __('ideas.delete') }}
                                                </x-accordion-action>
                                            @endcan
                                            @can('idea-to-sphere', $character)
                                                <x-accordion-action method="GET"
                                                                    action="{{ route('characters.ideas.sphere', ['character' => $character, 'idea' => $idea]) }}"
                                                                    icon="fa-solid fa-boxes-stacked"
                                                >
                                                    {{ __('ideas.to_sphere') }}
                                                </x-accordion-action>
                                            @endcan
                                        </x-slot>
                                    </x-accordion-item>
                                @endforeach

                                @can('add-idea', $character)
                                    <x-accordion-action class="mt-2 w-full border-t"
                                                        method="GET"
                                                        action="{{ route('characters.ideas.create', ['character' => $character]) }}"
                                                        icon="fa-solid fa-circle-plus"
                                    >
                                        {{ __('ideas.create') }}
                                    </x-accordion-action>
                                @endcan
                            </div>
                        @endif

                        <x-form.error name="ideas"/>
                    </x-card>
                </div>
            @endif
        @endcan

        @if (count($perks))
            <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                @if ($perks->get('combat'))
                    <x-card class="w-auto my-auto">
                        <x-header>
                            {{ __('perks.combat') }}
                        </x-header>

                        <div class="space-y-4">
                            @foreach ($perks->get('combat')->sortByDesc('active') as $perkVariant)
                                <x-perk-card :character="$character" :perk="$perkVariant->perk" :perkVariant="$perkVariant"/>
                            @endforeach
                        </div>
                    </x-card>
                @endif

                @if ($perks->get('noncombat'))
                    <x-card class="w-auto my-auto">
                        <x-header>
                            {{ __('perks.noncombat') }}
                        </x-header>

                        <div class="space-y-4">
                            @foreach ($perks->get('noncombat')->sortByDesc('active') as $perkVariant)
                                <x-perk-card :character="$character" :perk="$perkVariant->perk" :perkVariant="$perkVariant"/>
                            @endforeach
                        </div>
                    </x-card>
                @endif
            </div>
        @endif

        <x-form.error name="vox"/>

        @can('update-charsheet-gm', $character)
            <div class="flex w-full justify-center">
                <x-character.action href="{{ route('characters.perks.edit', $character) }}">
                    {{ __('charsheet.edit.perks') }}
                </x-character.action>
            </div>
        @endcan

        @can('see-player-only-info', $character)
            @if (count($character->fates))
                <x-card class=" mx-auto w-max max-w-full">
                    <x-header>
                        {{ __('charsheet.fates') }}
                    </x-header>

                    <div class="divide-y divide-dashed">
                        @foreach ($character->fates as $fate)
                            <div class="p-2">
                                <div class="flex text-sm font-semibold space-x-2 mb-2">
                                    @if ($fate->isDual())
                                        <div class="bg-gray-200 px-2 rounded-full">
                                            {{ __('fates.dual') }}
                                        </div>
                                    @elseif ($fate->isAmbition())
                                        <div class="bg-yellow-200 px-2 rounded-full">
                                            {{ __('fates.ambition') }}
                                        </div>
                                    @elseif ($fate->isFlaw())
                                        <div class="bg-blue-200 px-2 rounded-full">
                                            {{ __('fates.flaw') }}
                                        </div>
                                    @endif

                                    @if ($fate->isOnetime())
                                        <div class="bg-green-200 px-2 rounded-full">
                                            {{ __('fates.onetime') }}
                                        </div>
                                    @else
                                        <div class="bg-purple-200 px-2 rounded-full">
                                            {{ __('fates.continuous') }}
                                        </div>
                                    @endif
                                </div>
                                <x-markdown class="text-lg min-w-full">{!! $fate->text !!}</x-markdown>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif
        @endcan

        @can('update-charsheet-gm', $character)
            <div class="flex w-full justify-center">
                <x-character.action href="{{ route('characters.fates.edit', $character) }}">
                    {{ __('charsheet.edit.fates') }}
                </x-character.action>
            </div>
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
