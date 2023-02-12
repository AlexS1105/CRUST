<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
    @foreach ($perks as $perk)
        @php
            $characterPerk = $character->perks->firstWhere('id', $perk->id);
        @endphp

        <div id="perk-{{$perk->id}}" class="border border-gray-400 rounded overflow-hidden opacity-50">
            <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                <div class="flex text-sm w-full items-center font-bold uppercase">
                    <div class="p-2 border-r border-gray-400">
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
                        @checked($characterPerk != null)
                    />
                </div>
            </div>

            @if (isset($perk->description))
                <x-markdown class="p-1 min-w-full">{!! $perk->description !!}</x-markdown>
            @endif

            <div id="perk-data-{{$perk->id}}" class="flex items-center hidden">
                <input
                    class="p-1 text-xs border-b-0 border-r-0 border-l-0 focus:border-gray-400 border-gray-400 focus:ring-transparent w-full"
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

<div class="space-y-2 text-lg font-bold">
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.perks') }}
        <div id="perk-count">
            0
        </div>
        / {{ $maxPerks }}
    </div>
    <div class="font-bold text-lg text-right flex justify-end gap-2">
        {{ __('charsheet.points.perk_points') }}
        <div id="perk-cost">
            0
        </div>
        / {{ $character->perk_points }}
    </div>
</div>

<x-form.error name="perks"/>

<script>
    let maxPerks = @json($maxPerks);
    let perkPoints = @json($character->perk_points);
</script>
