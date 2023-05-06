<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
    @foreach ($techniques as $technique)
        @php
            $characterTechnique = $character->techniques->firstWhere('id', $technique->id);
        @endphp

        <div id="technique-{{$technique->id}}" class="border border-gray-400 rounded overflow-hidden opacity-50">
            <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                <div class="flex text-sm w-full items-center font-bold uppercase">
                    <div class="p-2">
                        {{ $technique->name }}
                    </div>
                </div>
                <div class="p-1">
                    <input class="w-6 h-6"
                        type="checkbox"
                        name="techniques[{{ $technique->id }}][selected]"
                        id="techniques[{{ $technique->id }}][selected]"
                        onchange="updateTechniques();"
                        data-technique-id="{{ $technique->id }}"
                        data-technique-cost="{{ $technique->cost }}"
                        @checked(old('techniques.' . $technique->id . '.selected', $characterTechnique != null))
                    />
                </div>
            </div>

            @if (isset($technique->description))
                <x-markdown class="p-1 min-w-full">{!! $technique->description !!}</x-markdown>
            @endif
        </div>
    @endforeach
</div>

<div class="space-y-2 text-lg font-bold">
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.techniques') }}
        <div id="technique-count">
            0
        </div>
        / {{ $character->max_technique_amount }}
    </div>
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.technique_points') }}
        <div id="technique-cost">
            0
        </div>
        / <div id="technique-points">{{ old('technique_points', $character->technique_points) }}</div>
    </div>
</div>

<x-tip text="character.techniques"/>
<x-form.error name="techniques"/>

@can('update-charsheet-gm', $character)
    <x-form.input name="technique_points" type="number" required min="0" max="100" onchange="updateTechniquePoints()" :value="old('technique_points', $character->technique_points)"/>

    <x-form.error name="technique_points"/>
@endcan

<script>
    let maxTechniques = @json($character->max_technique_amount);
    let techniquePoints = @json($character->technique_points);
</script>
