@extends('layouts.app')

@section('header', __('characters.edit'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('characters.stats.update', $character->login) }}" method="PATCH">
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
                <x-tip text="character.stats.update"/>
                <x-form.error name="stats"/>

                @can('update-charsheet-gm')
                    <x-form.checkbox name="stats_handled" value="{{ old('stats_handled', $character->stats_handled) }}" />
                    <x-tip text="character.stats.handled"/>
                @endcan
            </x-form.card>

            <x-button-submit/>
        </x-form.base>
    </x-container>
@endsection

@push('scripts')
    <script>
        var maxStats = @json($character->estitence);
    </script>
@endpush
