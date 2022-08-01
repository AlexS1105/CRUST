<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
  @foreach ($perks as $perk)
    @php
      $characterPerkVariant = $character->perkVariants->firstWhere('perk_id', $perk->id);
    @endphp
    <div id="perk-{{$perk->id}}" class="border border-gray-400 rounded overflow-hidden opacity-50">
      <div class="flex justify-between border-b bg-gray-100 border-gray-400">
        <div class="flex justify-between text-sm w-full items-center font-bold p-1 uppercase space-x-1">
          <div>
            {{ $perk->name }}
          </div>
          <div class="space-y-0.5 text-xs">
            @if ($perk->type->isCombat())
              <div class="bg-red-200 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.combat') }}
              </div>
            @else
              <div class="bg-green-200 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.noncombat') }}
              </div>
            @endif

            @if ($perk->type->hasFlag(App\Enums\PerkType::Attack))
              <div class="bg-orange-200 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.attack') }}
              </div>
            @endif

            @if ($perk->type->hasFlag(App\Enums\PerkType::Defence))
              <div class="bg-blue-300 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.defence') }}
              </div>
            @endif
          </div>
        </div>
      </div>
      
      @if (isset($perk->general_description))
        <div class="prose markdown p-1 min-w-full border-b">{!! $perk->general_description !!}</div>
      @endif

      <select
        name="perks[{{ $perk->id }}][id]"
        id="perks[{{ $perk->id }}][id]"
        class="focus:ring-transparent block w-full border-none p-1 pr-10 cursor-pointer {{isset($perk->general_description) ? "bg-gray-50" : ""}}" onchange="updatePerks();"
        data-perk-id="{{ $perk->id }}"
        data-combat="{{ $perk->type->isCombat() }}"
        data-attack="{{ $perk->type->hasFlag(App\Enums\PerkType::Attack) }}"
        data-defence="{{ $perk->type->hasFlag(App\Enums\PerkType::Defence) }}"
      >
        <option value="-1" selected>{{ __('perks.select') }}</option>
        @foreach ($perk->variants as $variant)
          <option class="text-ellipsis" value="{{ $variant->id }}" {{ old("perks.$perk->id.id") == $variant->id || (isset($characterPerkVariant) ? $characterPerkVariant->id == $variant->id : false) ? 'selected' : '' }}>
            {{ $variant->description }}
          </option>
        @endforeach
      </select>
      <div id="perk-data-{{$perk->id}}" class="flex items-center hidden">
        <input
          class="p-1 text-xs border-b-0 border-r-0 border-l-0 focus:border-gray-400 border-gray-400 focus:ring-transparent w-full"
          name="perks[{{ $perk->id }}][note]"
          id="perks[{{ $perk->id }}][note]"
          type="text"
          placeholder="{{ __('perks.placeholder.note') }}"
          value="{{ old('perks.'.$perk->id.'.note', isset($characterPerkVariant) ? $characterPerkVariant->pivot->note : null) }}"
        />
      </div>
    </div>
  @endforeach
</div>

<div class="space-y-2 text-lg font-bold">
  <div class="flex justify-center gap-2 bg-green-100 rounded-full px-2 w-fit my-auto">
    {{ __('charsheet.points.active_noncombat_perks') }}
    <div id="noncombat_perk_count">
      0
    </div>
    / {{ $maxActivePerks }}
  </div>
  <div class="space-y-2">
    <div class="flex justify-center gap-2 bg-red-100 rounded-full px-2">
      {{ __('charsheet.points.active_combat_perks') }}
      <div id="combat_perk_count">
        0
      </div>
      / {{ $maxActivePerks }}
    </div>
    <div class="flex justify-center gap-2 bg-orange-100 rounded-full px-2">
      {{ __('charsheet.points.combat_perk_attack') }}
      <div id="combat_perk_attack">
        0
      </div>
      / 1
    </div>
    <div class="flex justify-center gap-2 bg-blue-200 rounded-full px-2">
      {{ __('charsheet.points.combat_perk_defence') }}
      <div id="combat_perk_defence">
        0
      </div>
      / 1
    </div>
  </div>
</div>

<x-form.error name="perks"/>

<script>
  var edit = @json($edit);
  var maxActivePerks = @json($maxActivePerks)
</script>
