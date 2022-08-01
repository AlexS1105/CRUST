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

            @if ($perk->type->hasFlag(App\Enums\PerkType::Native))
              <div class="bg-purple-200 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.native') }}
              </div>
            @endif

            @if ($perk->type->hasFlag(App\Enums\PerkType::Unique))
              <div class="bg-yellow-200 px-1 rounded-full max-w-min ml-auto">
                {{ __('perks.types.unique') }}
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <select name="perks[{{ $perk->id }}][id]" id="perks[{{ $perk->id }}][id]" class="focus:ring-transparent block w-full border-none p-1 pr-10 cursor-pointer" onchange="updatePerks();" data-perk-id="{{ $perk->id }}" data-combat="{{ $perk->type->isCombat() }}" data-native="{{ $perk->type->hasFlag(App\Enums\PerkType::Native) }}">
        <option value="-1" selected>{{ __('perks.select') }}</option>
        @foreach ($perk->variants as $variant)
          <option class="text-ellipsis" value="{{ $variant->id }}" {{ old("perks.$perk->id.id") == $variant->id || (isset($characterPerkVariant) ? $characterPerkVariant->id == $variant->id : false) ? 'selected' : '' }}>
            {{ $variant->description }}
          </option>
        @endforeach
      </select>
      <div id="perk-data-{{$perk->id}}" class="flex items-center hidden">
        <div class="p-1 w-1/4 space-x-1 leading-none">
          <input
            class="focus:ring-0"
            name="perks[{{ $perk->id }}][active]" id="perks[{{ $perk->id }}][active]"
            type="checkbox"
            {{ old("perks.$perk->id.active", isset($characterPerkVariant) ? $characterPerkVariant->pivot->active : !$edit) ? 'checked' : '' }}
            onchange="updatePerks();"
          />
          <label for="perks[{{ $perk->id }}][active]">
            {{ __('perks.types.active') }}
          </label>
        </div>
        <input
          class="p-1 text-xs border-b-0 border-r-0 focus:border-gray-400 border-gray-400 focus:ring-transparent w-full"
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

<div class="space-y-2">
  @if (!$edit)
    <div class="flex justify-between text-right font-bold text-lg space-x-2">
      <div class="flex justify-end gap-2 bg-green-100 rounded-full px-2 w-fit">
        {{ __('charsheet.points.noncombat_perks') }}
        <div id="noncombat_perk_points">
          {{ $maxPerks }}
        </div> / {{ $maxPerks }}
      </div>
      <div class="flex justify-end gap-2 bg-red-100 rounded-full px-2">
        {{ __('charsheet.points.combat_perks') }}
        <div id="combat_perk_points">
          {{ $maxPerks }}
        </div> / {{ $maxPerks }}
      </div>
    </div>
  @endif

  <div class="flex justify-between text-right font-bold space-x-2">
    <div class="flex justify-end gap-2 bg-green-100 rounded-full px-2 w-fit">
      {{ __('charsheet.points.active_noncombat_perks') }}
      <div id="noncombat_perk_count">
        {{ $maxActivePerks }}
      </div>
    </div>
    <div class="flex justify-end gap-2 bg-red-100 rounded-full px-2">
      {{ __('charsheet.points.active_combat_perks') }}
      <div id="combat_perk_count">
        {{ $maxActivePerks }}
      </div>
    </div>
  </div>
</div>

<x-form.error name="perks"/>

<script>
  var edit = @json($edit);
  var maxPerks = @json($maxPerks ?? -1);
  var maxActivePerks = @json($maxActivePerks)
</script>
