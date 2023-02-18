@extends('layouts.app')

@section('header', __('characters.edit'))

@section('content')
    <x-container>
        <x-character.stages :character="$character"/>

        <x-form.base action="{{ route('characters.charsheet.update', $character->login) }}" method="PATCH">
            <x-form.card>
                <x-slot name="header">
                    {{ __('charsheet.stats') }}
                </x-slot>

                <x-character.charsheet.stats-edit :character="$character" />

                <div class="font-bold text-lg text-right flex justify-end">
                    <div class="mr-2">
                        {{ __('charsheet.points.stats') }}
                    </div>
                    <div class="mr-2" id="stat-points">
                        {{ $character->estitence - $character->charsheet->stats_sum }}
                    </div>
                    <div>
                        / {{ $character->estitence }}
                    </div>
                </div>
                <x-tip text="character.stats.penalties"/>
                <x-form.error name="stats"/>

                <x-form.checkbox name="stats_handled" value="{{ old('stats_handled', $character->stats_handled) }}" />

                <x-tip text="character.stats.handled"/>
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('skills.index') }}
                </x-slot>

                <x-character.skill-selector :character="$character" :skills="$skills" />
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('charsheet.crafts.index') }}
                </x-slot>

                <div class="grid md:grid-cols-3 gap-4">
                    <x-character.charsheet.craft-selector color="purple"
                                                          craft="magic"
                                                          :character="$character"
                    />
                    <x-character.charsheet.craft-selector color="yellow"
                                                          craft="tech"
                                                          :character="$character"
                    />
                    <x-character.charsheet.craft-selector color="gray"
                                                          craft="general"
                                                          :character="$character"
                    />
                </div>

                <x-tip text="character.crafts"/>
                <x-form.error name="crafts"/>

                <div class="space-y-2">
                    <div class="text-lg font-bold uppercase text-gray-700">
                        {{ __('charsheet.narrative_crafts.title') }}
                    </div>
                    <div class="space-y-2" id="narrative_crafts">

                    </div>

                    <div class="font-bold text-lg text-right flex justify-end gap-2">
                        {{ __('charsheet.points.narrative_crafts') }}
                        <div id="narrative_crafts_max">
                            0
                        </div>
                    </div>
                </div>

                <x-tip text="character.narrative_crafts"/>
                <x-form.error name="narrative_crafts"/>
                <x-form.error name="narrative_crafts.*.name"/>
                <x-form.error name="narrative_crafts.*.description"/>
            </x-form.card>

            @if (!$character->registered)
                @if (count($perks))
                    <x-form.card>
                        <x-slot name="header">
                            {{ __('charsheet.perks') }}
                        </x-slot>

                        <x-character.perks :character="$character" :perks="$perks"
                                           :maxPerks="$settings->max_perks"/>
                    </x-form.card>
                @endif

                <x-form.card>
                    <x-slot name="header">
                        {{ __('charsheet.fates') }}
                    </x-slot>

                    <x-character.fates :character="$character" :maxFates="$settings->max_fates"/>
                    <x-tip text="character.fates"/>
                </x-form.card>
            @endif

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection

@push('scripts')
    <script>
        var maxStats = @json($character->estitence);
        var magicCrafts = @json(array_map(function($instance) { return $instance->value; }, App\Enums\CharacterCraft::getMagicCrafts()));
        var techCrafts = @json(array_map(function($instance) { return $instance->value; }, App\Enums\CharacterCraft::getTechCrafts()));
        var _narrativeCrafts = @json(old('narrative_crafts', $character->narrativeCrafts)) ||
        [];
        var craftNameText = @json(__('charsheet.narrative_crafts.name'));
        var craftDescriptionText = @json(__('charsheet.narrative_crafts.description'));
    </script>
@endpush
