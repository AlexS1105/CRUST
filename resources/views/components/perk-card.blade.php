<div {{ $attributes->merge(['class' => 'border border-gray-400 rounded-xl overflow-hidden max-w-fit']) }}>
  <div class="flex justify-between border-b bg-gray-100 border-gray-400">
    <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-2">
      {{ $perk->name }}
    </div>
    <div class="flex p-2 text-center font-bold text-lg border-gray-400 border-l">
      {{ $perk->cost }}

      @if($perkVariant->pivot->cost_offset)
        + {{ $perkVariant->pivot->cost_offset }}
      @endif
    </div>
  </div>
  <div class="flex bg-gray-50 border-b border-gray-400 px-2 py-1 space-x-2 uppercase font-bold text-sm  ">
    @if ($perk->type->isCombat())
      <div class="bg-red-100 px-2 rounded-full">
        {{ __('perks.types.combat') }}
      </div>
    @else
    <div class="bg-green-100 px-2 rounded-full">
      {{ __('perks.types.noncombat') }}
    </div>
    @endif

    @if ($perk->type->hasFlag(App\Enums\PerkType::Native))
      <div class="bg-purple-100 px-2 rounded-full">
        {{ __('perks.types.native') }}
      </div>
    @endif

    @if ($perk->type->hasFlag(App\Enums\PerkType::Unique))
      <div class="bg-yellow-100 px-2 rounded-full">
        {{ __('perks.types.unique') }}
      </div>
    @endif
  </div>
  <div class="prose markdown p-2">{!! $perkVariant->description !!}</div>
  @if($perkVariant->pivot->note)
    <div class="px-2 py-1 border-t bg-gray-50 italic">
      {{ $perkVariant->pivot->note }}
    </div>
  @endif
</div>
