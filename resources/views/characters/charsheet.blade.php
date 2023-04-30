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

                @can('update-charsheet-gm', $character)
                    <x-form.checkbox name="stats_handled" value="{{ old('stats_handled', $character->stats_handled) }}" />
                    <x-tip text="character.stats.handled"/>

                    <x-form.checkbox name="estitence_reduce" value="{{ old('estitence_reduce', $character->estitence_reduce) }}" />
                    <x-tip text="character.estitence_reduce"/>
                @endcan
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('skills.index') }}
                </x-slot>

                <x-character.skill-selector :character="$character" :skills="$skills" />
            </x-form.card>

            @if (count($perks))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('charsheet.perks') }}
                    </x-slot>

                    <x-character.perks :character="$character" :perks="$perks"
                                       :maxPerks="$settings->max_perks"/>
                </x-form.card>
            @endif

            @if (count($talents))
                <x-form.card>
                    <x-slot name="header">
                        {{ __('talents.index') }}
                    </x-slot>

                    <x-character.talents :character="$character" :talents="$talents" />
                </x-form.card>
            @endif

            <x-form.card>
                <x-slot name="header">
                    {{ __('tides.index') }}
                </x-slot>

                <x-character.tides-edit :character="$character" />
                <x-tip text="character.tides"/>
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection

@push('scripts')
    <script>
        let maxStats = @json($character->estitence);
    </script>
@endpush
