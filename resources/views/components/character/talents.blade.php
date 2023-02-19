<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
    @foreach ($talents as $talent)
        @php
            $characterTalent = $character->talents->firstWhere('id', $talent->id);
        @endphp

        <div id="talent-{{$talent->id}}" class="border border-gray-400 rounded overflow-hidden opacity-50">
            <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                <div class="flex text-sm w-full items-center font-bold uppercase">
                    <div class="p-2 border-r border-gray-400">
                        {{ $talent->cost }}
                    </div>
                    <div class="p-2">
                        {{ $talent->name }}
                    </div>
                </div>
                <div class="p-1">
                    <input class="w-6 h-6"
                        type="checkbox"
                        name="talents[{{ $talent->id }}][selected]"
                        id="talents[{{ $talent->id }}][selected]"
                        onchange="updateTalents();"
                        data-talent-id="{{ $talent->id }}"
                        data-talent-cost="{{ $talent->cost }}"
                        @checked($characterTalent != null)
                    />
                </div>
            </div>

            @if (isset($talent->description))
                <x-markdown class="p-1 min-w-full">{!! $talent->description !!}</x-markdown>
            @endif
        </div>
    @endforeach
</div>

<div class="space-y-2 text-lg font-bold">
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.talents') }}
        <div id="talent-count">
            0
        </div>
        / {{ $character->max_talent_amount }}
    </div>
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.talent_points') }}
        <div id="talent-cost">
            0
        </div>
        / <div id="talent-points">{{ old('talent_points', $character->talent_points) }}</div>
    </div>
</div>

<x-tip text="character.talents"/>
<x-form.error name="talents"/>

@can('update-charsheet-gm', $character)
    <x-form.input name="talent_points" type="number" required min="0" max="100" onchange="updateTalentPoints()" :value="old('talent_points', $character->talent_points)"/>

    <x-form.error name="talent_points"/>
@endcan

<script>
    let maxTalents = @json($character->max_talent_amount);
    let talentPoints = @json($character->talent_points);
</script>