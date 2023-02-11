<x-character.charsheet.stats>
    <x-slot name="headerBody">
        (<span id="body-sum">{{ $character->charsheet->body_sum }}</span>)
    </x-slot>
    <x-slot name="headerEssence">
        (<span id="essence-sum">{{ $character->charsheet->essence_sum }}</span>)
    </x-slot>

    @foreach ($character->charsheet->stats as $stat => $value)
        <x-slot :name="$stat">
            <input id="stats[{{$stat}}]"
                   name="stats[{{$stat}}]"
                   type="number"
                   min="1"
                   max="100"
                   value="{{ $value }}"
                   oninput="updateStatsSum()"
            >
        </x-slot>
    @endforeach
</x-character.charsheet.stats>
