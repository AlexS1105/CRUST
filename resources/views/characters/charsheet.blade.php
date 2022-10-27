@extends('layouts.app')

@section('header', __('characters.edit'))

@section('content')
    <x-container>
        <x-character.stages :character="$character"/>

        <x-form.base action="{{ route('characters.charsheet.update', $character->login) }}" method="PATCH">
            <x-form.card>
                <x-slot name="header">
                    {{ __('charsheet.skills') }}
                </x-slot>

                <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto min-content">
                    @foreach (App\Enums\CharacterSkill::cases() as $instance)
                        @php
                            $skill = $instance->value;
                            $value = old('skills.'.$skill, $character->charsheet->skills[$skill]);
                        @endphp

                        <div class="text-lg text-right">
                            {{ $instance->localized() }}
                        </div>
                        <div class="space-x-4 flex">
                            <input class="w-full shrink" type="range" id="skills[{{ $skill }}]"
                                   name="skills[{{ $skill }}]" min="0" max="10" value="{{ $value }}"
                                   oninput="updateSkillSum(this)"/>
                        </div>
                        <output id="{{ $skill }}" class="font-bold text-xl w-4">{{ $value }}</output>
                    @endforeach
                </div>

                <div class="font-bold text-lg text-right flex justify-end">
                    <div class="mr-2">
                        {{ __('charsheet.points.skills') }}
                    </div>
                    <div class="mr-2" id="skill_points">
                        {{ $settings->skill_points - array_sum($character->charsheet->skills) }}
                    </div>
                    <div>
                        / {{ $settings->skill_points }}
                    </div>
                </div>
                <x-tip text="character.skills"/>
                <x-form.error name="skills"/>
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
                                           :maxActivePerks="$settings->max_active_perks" :edit="false"/>

                        <x-tip text="character.perks"/>
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
        var maxSkills = @json($settings->skill_points);
        var magicCrafts = @json(array_map(function($instance) { return $instance->value; }, App\Enums\CharacterCraft::getMagicCrafts()));
        var techCrafts = @json(array_map(function($instance) { return $instance->value; }, App\Enums\CharacterCraft::getTechCrafts()));
        var _narrativeCrafts = @json(old('narrative_crafts', $character->narrativeCrafts)) ||
        [];
        var craftNameText = @json(__('charsheet.narrative_crafts.name'));
        var craftDescriptionText = @json(__('charsheet.narrative_crafts.description'));
    </script>
@endpush
