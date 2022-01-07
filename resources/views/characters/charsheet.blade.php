<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('charsheet.edit') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <x-character.stages :character=$character />
    <form class="space-y-8" method="POST" action="{{ route('characters.charsheet.update', $character->login) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.skills') }}
        </x-slot>

        <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto min-content">
          @foreach (App\Enums\CharacterSkill::getInstances() as $instance)
            @php
              $skill = $instance->key();
              $value = $character->charsheet->skills[$skill];
            @endphp

            <div class="text-lg text-right">
              {{ $instance->localized() }}
            </div>
            <div class="space-x-4 flex">
              <input class="w-full shrink" type="range" id="skills[{{ $skill }}]" name="skills[{{ $skill }}]" min="0" max="10" value="{{ $value }}" oninput="updateSkillSum(this)"/>
            </div>
            <output id="{{ $skill }}" class="font-bold text-xl w-4">{{ $value }}</output>
          @endforeach
        </div>

        <div class="font-bold text-lg text-right flex justify-end">
          <div class="mr-2">
            {{ __('charsheet.points.skills') }}
          </div>
          <div class="mr-2" id="skill_points">
            {{ $maxSkills - array_sum($character->charsheet->skills) }}
          </div>
          <div>
            / {{ $maxSkills }}
          </div>
        </div>

        <x-form.error name="skills"/>
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.crafts') }}
        </x-slot>

        <div class="grid grid-cols-3 gap-4">
          <div class="bg-purple-100 rounded-2xl p-2">
            <div class="mb-1 text-center font-bold bg-purple-300 rounded-full flex justify-center">
              <div class="mr-2">
                {{ __('skill.magic') }}
              </div>
              <div id="magic_points_spent">
                0
              </div>
              /
              <div id="magic_points_max">
                {{ $character->charsheet->skills['magic'] }}
              </div>
            </div>
            <div class="space-y-1 px-1 pb-1">
              @foreach (App\Enums\CharacterCraft::getMagicCrafts() as $instance)
                @php
                  $craft = $instance->key();
                  $value = $character->charsheet->crafts[$craft];
                  $max = $instance->getMaxTier();
                @endphp
                <div class="px-3 py-1 bg-purple-200 rounded-lg">
                  {{ $instance->localized() }}
                  <div class="flex space-x-2">
                    <input class="w-full" type="range" id="crafts[{{ $craft }}]" name="crafts[{{ $craft }}]" min="0" max="{{ $max }}" value="{{ $value }}" oninput="updateCraftsSum(this)"/>
                    <output class="font-bold flex-none">{{ $value }}</output>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="bg-yellow-100 rounded-2xl p-2">
            <div class="mb-1 text-center font-bold bg-yellow-300 rounded-full flex justify-center">
              <div class="mr-2">
                {{ __('skill.tech') }}
              </div>
              <div id="tech_points_spent">
                0
              </div>
              /
              <div id="tech_points_max">
                {{ $character->charsheet->skills['tech'] }}
              </div>
            </div>
            <div class="space-y-1 px-1 pb-1">
              @foreach (App\Enums\CharacterCraft::getTechCrafts() as $instance)
                @php
                  $craft = $instance->key();
                  $value = $character->charsheet->crafts[$craft];
                  $max = $instance->getMaxTier();
                @endphp
                <div class="px-3 py-1 bg-yellow-200 rounded-lg">
                  {{ $instance->localized() }}
                  <div class="flex space-x-2">
                    <input class="w-full" type="range" id="crafts[{{ $craft }}]" name="crafts[{{ $craft }}]" min="0" max="{{ $max }}" value="{{ $value }}" oninput="updateCraftsSum(this)"/>
                    <output class="font-bold flex-none">{{ $value }}</output>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="bg-gray-100 rounded-2xl p-2">
            <div class="mb-1 text-center font-bold bg-gray-300 rounded-full flex justify-center">
              <div class="mr-2">
                {{ __('charsheet.crafts_general') }}
              </div>
              <div id="general_points_max">
                0
              </div>
            </div>
            <div class="space-y-1 px-1 pb-1">
              @foreach (App\Enums\CharacterCraft::getGeneralCrafts() as $instance)
                @php
                  $craft = $instance->key();
                  $value = $character->charsheet->crafts[$craft];
                  $max = $instance->getMaxTier();
                @endphp
                <div class="px-3 py-1 bg-gray-200 rounded-lg">
                  {{ $instance->localized() }}
                  <div class="flex space-x-2">
                    <input class="w-full" type="range" id="crafts[{{ $craft }}]" name="crafts[{{ $craft }}]" min="0" max="{{ $max }}" value="{{ $value }}" oninput="updateCraftsSum(this)"/>
                    <output class="font-bold flex-none">{{ $value }}</output>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <x-form.error name="crafts"/>

        <div class="space-y-2">
          <div class="text-lg font-bold uppercase text-gray-700">
            {{ __('charsheet.narrative_crafts.title') }}
          </div>
          <div class="space-y-2" id="narrative_crafts">

          </div>
  
          <div class="font-bold text-lg text-right flex justify-end gap-2">
            {{ __('charsheet.points.narrative_crafts') }} 
            <div id="narrative_crafts_max">
              0
            </div>
          </div>
        </div>

        <x-form.error name="narrative_crafts"/>
        <x-form.error name="narrative_crafts.*.name"/>
        <x-form.error name="narrative_crafts.*.description"/>
      </x-form.card>

      @if (!$character->registered)
        @if (count($perks))
          <x-form.card>
            <x-slot name="header">
              {{ __('charsheet.perks') }}
            </x-slot>

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
                        <div class="bg-red-200 px-1 rounded-full">
                          {{ __('perks.types.combat') }}
                        </div>
                        @else
                        <div class="bg-green-200 px-1 rounded-full">
                          {{ __('perks.types.noncombat') }}
                        </div>
                        @endif
            
                        @if ($perk->type->hasFlag(App\Enums\PerkType::Native))
                          <div class="bg-purple-200 px-1 rounded-full">
                            {{ __('perks.types.native') }}
                          </div>
                        @endif
                      </div>
                    </div>
                    <div class="px-1 leading-none my-auto text-sm text-center font-bold border-gray-400 border-l">
                      {{ $perk->cost }}
                    </div>
                  </div>
                  
                  <select name="perks[{{ $perk->id }}][id]" id="perks[{{ $perk->id }}][id]" class="focus:ring-transparent block w-full border-none p-1 pr-10 cursor-pointer" value="Test" onchange="updatePerks();" data-perk-id="{{ $perk->id }}" data-cost="{{ $perk->cost }}" data-combat="{{ $perk->type->isCombat() }}">
                    <option value="-1" selected>{{ __('perks.select') }}</option>
                    @foreach ($perk->variants as $variant)
                      <option class="text-ellipsis" value="{{ $variant->id }}" {{ old("perks.$perk->id.id") == $variant->id || (isset($characterPerkVariant) ? $characterPerkVariant->id == $variant->id : false) ? 'selected' : '' }}>
                        {{ $variant->description }}
                      </option>
                    @endforeach
                  </select>
                  <div id="perk-data-{{$perk->id}}" class="flex items-center hidden">
                    <input
                      class="p-1 text-xs border-b-0 border-l-0 border-r-0 focus:border-gray-400 border-gray-400 focus:ring-transparent w-1/4"
                      name="perks[{{ $perk->id }}][cost_offset]" id="perks[{{ $perk->id }}][cost_offset]"
                      type="number"
                      min=0 max=100
                      placeholder="{{ __('perks.placeholder.cost_offset') }}"
                      value="{{ old("perks.$perk->id.cost_offset", isset($characterPerkVariant) && $characterPerkVariant->pivot->cost_offset != 0 ? $characterPerkVariant->pivot->cost_offset : null) }}"
                      onchange="updatePerks();"
                    >
                    <input
                      class="p-1 text-xs border-b-0 border-r-0 focus:border-gray-400 border-gray-400 focus:ring-transparent w-full"
                      name="perks[{{ $perk->id }}][note]"
                      id="perks[{{ $perk->id }}][note]"
                      type="text"
                      placeholder="{{ __('perks.placeholder.note') }}"
                      value="{{ old('perks.'.$perk->id.'.note', isset($characterPerkVariant) ? $characterPerkVariant->pivot->note : null) }}"
                    >
                  </div>
                </div>
              @endforeach
            </div>

            <div class="flex justify-between text-right font-bold text-lg space-x-2">
              <div class="flex justify-end gap-2 bg-green-100 rounded-full px-2 w-fit">
                <div class="grow">{{ __('charsheet.points.noncombat_perks') }}</div>
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

            <x-form.error name="perks"/>
          </x-form.card>
        @endif

        @if (count($traits))
          <x-form.card>
            <x-slot name="header">
              {{ __('charsheet.trait') }}
            </x-slot>

            <div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
              @php
                $characterTrait = $character->trait();
                $characterSubtrait = $character->subtrait();
              @endphp
              <input name="trait" id="trait" type="hidden" value="{{ $characterTrait ? $characterTrait->id : '' }}">
              <input name="subtrait" id="subtrait" type="hidden" value="{{ $characterSubtrait ? $characterSubtrait->id : '' }}">
              
              @foreach ($traits as $trait)
                <div
                  id="trait-{{ $trait->id }}"
                  class="border border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 rounded overflow-hidden opacity-50 cursor-pointer hover:shadow"
                  data-id="{{ $trait->id }}"
                  data-subtrait="{{ $trait->subtrait }}"
                  onclick="selectTrait(this)"
                >
                  <div class="border-b bg-{{ $trait->subtrait ? 'blue' : 'green' }}-100 border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 px-1">
                    <div class="font-bold uppercase">
                      {{ $trait->name }}
                    </div>
                    @if($trait->subtrait)
                      <div class="text-xs">
                        {{ __('traits.subtrait') }}
                      </div>
                    @endif
                  </div>
      
                  <div class="bg-{{ $trait->subtrait ? 'blue' : 'green' }}-50 px-1 text-sm italic border-b border-{{ $trait->subtrait ? 'blue' : 'green' }}-200">
                    {{ __('traits.races') }}: {{ $trait->races }}
                  </div>
                  <div class="prose markdown p-1 min-w-full text-sm">{!! $trait->description !!}</div>
                </div>
              @endforeach
            </div>

            <x-form.input name="note_trait" placeholder="{{ __('traits.placeholder.note_trait') }}" :value="old('note_trait', $characterTrait->pivot->note)" />
            <x-form.input name="note_subtrait" placeholder="{{ __('traits.placeholder.note_subtrait') }}" :value="old('note_subtrait', $characterSubtrait->pivot->note)" />

            <x-form.error name="traits"/>
          </x-form.card>
        @endif

        <x-form.card>
          <x-slot name="header">
            {{ __('charsheet.fates') }}
          </x-slot>

          <div class="space-y-2">
            <div class="space-y-2" id="fates">

            </div>
    
            <div class="font-bold text-lg text-right flex justify-end gap-2">
              {{ __('charsheet.points.fates') }} 
              <div id="fates_max">
                {{ $maxFates }}
              </div>
            </div>
          </div>

          <x-form.error name="fates"/>
          <x-form.error name="fates.*.text"/>
          <x-form.error name="fates.*.type"/>
        </x-form.card>
      @endif

      <x-button>
        {{ __('ui.submit') }}
      </x-button>
    </form>

    <script>
      var maxSkills = @json($maxSkills);
      var maxPerks = @json($maxPerks);
      var maxFates = @json($maxFates);
      var magicCrafts = @json(array_map(function($instance) { return $instance->key(); }, App\Enums\CharacterCraft::getMagicCrafts()));
      var techCrafts = @json(array_map(function($instance) { return $instance->key(); }, App\Enums\CharacterCraft::getTechCrafts()));
      var _narrativeCrafts = @json(old('narrative_crafts', $character->narrativeCrafts)) || [];
      var _fates = @json(old('fates', $character->fates)) || [];
      var craftNameText = @json(__('charsheet.narrative_crafts.name'));
      var craftDescriptionText = @json(__('charsheet.narrative_crafts.description'));
      var ambitionLabelText = @json(__('fates.ambition'));
      var flawLabelText = @json(__('fates.flaw'));
      var continiousLabelText = @json(__('fates.continious'));
      var fateText = @json(__('fates.placeholder.text'));
    </script>
  </x-container>
</x-app-layout>
