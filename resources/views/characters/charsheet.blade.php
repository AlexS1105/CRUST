<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('charsheet.edit.title') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <x-character.stages :character="$character" />
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

            <x-character.perks :character="$character" :perks="$perks" :maxPerks="$maxPerks" :maxActivePerks="$maxActivePerks" :edit="false" />
          </x-form.card>
        @endif

        @if (count($traits))
          <x-form.card>
            <x-slot name="header">
              {{ __('charsheet.trait') }}
            </x-slot>

            <x-character.traits :character="$character" :traits="$traits" />
          </x-form.card>
        @endif

        <x-form.card>
          <x-slot name="header">
            {{ __('charsheet.fates') }}
          </x-slot>

          <x-character.fates :character="$character" :maxFates="$maxFates" />
        </x-form.card>
      @endif

      <x-button>
        {{ __('ui.submit') }}
      </x-button>
    </form>

    <script>
      var maxSkills = @json($maxSkills);
      var magicCrafts = @json(array_map(function($instance) { return $instance->key(); }, App\Enums\CharacterCraft::getMagicCrafts()));
      var techCrafts = @json(array_map(function($instance) { return $instance->key(); }, App\Enums\CharacterCraft::getTechCrafts()));
      var _narrativeCrafts = @json(old('narrative_crafts', $character->narrativeCrafts)) || [];
      var craftNameText = @json(__('charsheet.narrative_crafts.name'));
      var craftDescriptionText = @json(__('charsheet.narrative_crafts.description'));
    </script>
  </x-container>
</x-app-layout>
