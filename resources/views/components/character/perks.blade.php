<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
    @foreach ($perks as $perk)
        @php
            $characterPerk = $character->perks->firstWhere('id', $perk->id);
        @endphp

        <div id="perk-{{$perk->id}}" class="border border-gray-400 dark:border-gray-900 rounded overflow-hidden opacity-50">
            <div class="flex justify-between border-b bg-gray-100 dark:bg-gray-700 dark:text-gray-200 border-gray-400 dark:border-gray-900">
                <div class="flex text-sm w-full items-center font-bold uppercase">
                    <div class="p-2 border-r border-gray-400 dark:border-gray-900">
                        {{ $perk->cost }}
                    </div>
                    <div class="p-2">
                        {{ $perk->name }}
                    </div>
                </div>
                <div class="p-1">
                    <input class="w-6 h-6"
                        type="checkbox"
                        name="perks[{{ $perk->id }}][selected]"
                        id="perks[{{ $perk->id }}][selected]"
                        onchange="updatePerks();"
                        data-perk-id="{{ $perk->id }}"
                        data-perk-cost="{{ $perk->cost }}"
                        @checked(old('perks.' . $perk->id . '.selected', $characterPerk != null))
                    />
                </div>
            </div>

            @if (isset($perk->description))
                <x-markdown class="p-1 min-w-full">{!! $perk->description !!}</x-markdown>
            @endif

            <div id="perk-data-{{$perk->id}}" class="flex items-center hidden">
                <input
                    class="p-1 text-xs border-b-0 border-r-0 border-l-0 dark:bg-gray-700 dark:text-gray-300 focus:border-gray-400 dark:border-gray-900 border-gray-400 dark:border-gray-900 focus:ring-transparent w-full"
                    name="perks[{{ $perk->id }}][note]"
                    id="perks[{{ $perk->id }}][note]"
                    type="text"
                    placeholder="{{ __('perks.placeholder.note') }}"
                    value="{{ old('perks.'.$perk->id.'.note', $characterPerk?->pivot->note) }}"
                />
            </div>
        </div>
    @endforeach
</div>

<div class="space-y-2 text-lg font-bold dark:text-gray-300">
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.perks') }}
        <div id="perk-count">
            0
        </div>
        / <div id="max-perk-amount">{{ old('perks_amount', $character->perks_amount ?? $character->max_perk_amount) }}</div>
    </div>
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.perk_points') }}
        <div id="perk-cost">
            0
        </div>
        / <div id="perk-points">{{ old('perk_points', $character->perk_points) }}</div>
    </div>
</div>

<x-tip text="character.perks"/>
<x-form.error name="perks"/>

@can('update-charsheet-gm', $character)
    <x-form.input name="perk_points" type="number" required min="0" max="1000" onchange="updatePerkPoints()" :value="old('perk_points', $character->perk_points)"/>
    <x-form.input name="perks_amount" type="number" min="0" max="1000" onchange="updateMaxPerksAmount()" :value="old('perks_amount', $character->perks_amount)"/>
@endcan

<script>
    let maxPerks = @json($character->max_perk_amount);
    let perkPoints = @json($character->perk_points);
</script>
