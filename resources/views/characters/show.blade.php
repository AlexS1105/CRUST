<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center text-gray-600">
      <div class="flex-shrink-0">
        <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
          {{ $character->name }}
        </h2>
        <div class="font-thin text-base">
          {{ __('label.player') }}: <a @can('view', $character->user)
            class="font-bold underline text-blue-600 visited:text-purple-600"
            href="{{ route('users.show', $character->user) }}"
          @endcan>{{ $character->user->login }}</a>
        </div>
        <div class="font-thin text-base">
          Discord: <span class="select-all">{{ $character->user->discord_tag }}</span>
        </div>
        <div class="font-thin text-base">
          {{ __('label.login') }}: <span class="select-all">{{ $character->login }}</span>
        </div>
      </div>
      <div class="flex flex-wrap justify-center">
        <x-application.actions :character="$character"/>
      </div>
      <div>
        <div class="flex items-center gap-4 font-bold text-xl">
          {{ __('label.status') }}: <x-character.status :status="$character->status"/>
        </div>
        @if ($character->registrar)
          <div class="font-thin text-base text-right mt-2">
            {{ __('label.registrar') }}: {{ $character->registrar->discord_tag }}
          </div>
        @endif
      </div>
    </div>
  </x-slot>
  
  <x-container class="max-w-6xl space-y-8">
    <div class="flex justify-center gap-8">
      <div class="bg-white rounded-xl max-w-md my-auto shadow-lg row-span-3 flex-none overflow-hidden">
        <img
          class="object-cover"
          src="{{ Storage::url($character->reference).'?='.$character->updated_at }}"
          alt="Character Reference"
        />
      </div>
      <div class="space-y-8 my-auto">
        @can('seeMainInfo', $character)
          <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
            <h1 class="font-bold text-xl mb-2">
              {{ __('characters.cards.main_info') }}
            </h1>
    
            <div class="text-lg">
              <div class="flex items-center gap-1">
                <b>{{ __('label.gender') }}:</b> 
                {{ $character->gender->localized() }}
                <div class="text-2xl fa {{ $character->gender->icon() }} text-{{ $character->gender->color() }}"></div>
              </div>
              <div>
                <b>{{ __('label.race') }}:</b> {{ $character->race }}
              </div>
              <div>
                <b>{{ __('label.age') }}:</b> {{ $character->age }}
              </div>
            </div>
          </div>
        @endcan

        @can('seeMainInfo', $character)
          <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
            <h1 class="font-bold text-xl mb-2">
              {{ __('label.description') }}
            </h1>

            <div class="prose markdown max-w-none">{!! $character->description !!}</div>
          </div>
        @endcan

        @if ($character->appearance)
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
            <h1 class="font-bold text-xl mb-2">
              {{ __('label.appearance') }}
            </h1>

            <div class="prose markdown max-w-none">{!! $character->appearance !!}</div>
            @can('seePlayerOnlyInfo', $character)
              <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('characters.skins.index', $character) }}">
                {{ __('skins.index') }}
              </a>
            @endcan
          </div>
        @endif

        @can('seePlayerOnlyInfo', $character)
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify max-w-max mx-auto">
            <h1 class="font-bold text-xl mb-2 max-w-max mx-auto">
              {{ __('label.vox') }}: {{ $character->vox }}
            </h1>

            <div class="space-x-2">
              @can('voxView', $character)
                <a class="font-bold underline text-blue-600" href="{{ route('characters.vox.index', $character) }}">
                  {{ __('vox.index') }}
                </a>
              @endcan
              @can('voxCreate', $character)
                <a class="font-bold underline text-blue-600 visited:text-purple-600" href="{{ route('characters.vox.create', $character) }}">
                  {{ __('vox.create') }}
                </a>
              @endcan
            </div>
          </div>
        @endcan
      </div>
    </div>

    @if(isset($character->charsheet->skills) || $character->charsheet->hasAnyCrafts())
      <div class="flex justify-center gap-8">
        @if(isset($character->charsheet->skills) && count($character->charsheet->skills))
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
            <h1 class="font-bold text-xl mb-2">
              {{ __('charsheet.skills') }}
            </h1>

            <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
              @foreach ($character->charsheet->skills as $skill => $value)
                <div class="text-lg font-semibold text-right">
                  {{ __('skill.'.$skill) }}
                </div>
                <div class="w-full bg-gray-200 rounded-full my-auto p-0.5">
                  <div class="bg-blue-400 rounded-full h-3" style="width: {{ $value * 10 }}%">
                    <div class="text-sm font-medium text-white text-center leading-none {{ $value == 0 ? "hidden" : "" }}">
                      {{ $value }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        @if ($character->charsheet->hasAnyCrafts() || count($character->narrativeCrafts))
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
            <h1 class="font-bold text-xl mb-2">
              {{ __('charsheet.crafts') }}
            </h1>
    
            @if($character->charsheet->hasAnyCrafts())
              <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
                @foreach ($character->charsheet->crafts as $craft => $value)
                  @php
                    $enum = App\Enums\CharacterCraft::fromKey(ucfirst($craft));
                  @endphp
                  @if($value > 0)
                    <div class="text-lg font-semibold text-right">
                      {{ __('craft.'.$craft) }}
                    </div>
                    <div class="w-full bg-gray-200 rounded-full my-auto p-0.5">
                      <div class="bg-blue-400 rounded-full h-3" style="width: {{ $value / $enum->getMaxTier() * 100 }}%">
                        <div class="text-sm font-medium text-white text-center leading-none {{ $value == 0 ? "hidden" : "" }}">
                          {{ $value }}
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            @endif

            @if ($character->charsheet->hasAnyCrafts() && count($character->narrativeCrafts))
              <hr class="my-4">
            @endif

            @if(count($character->narrativeCrafts))
              <div id="accordion-open" data-accordion="open">
              @foreach($character->narrativeCrafts as $craft)
                <h2 id="accordion-open-heading-{{$loop->iteration}}">
                  <button type="button" class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 border border-gray-200 {{$loop->last ? "" : "border-b-0"}}" data-accordion-target="#accordion-open-body-{{$loop->iteration}}" aria-expanded="false" aria-controls="accordion-open-body-{{$loop->iteration}}">
                    <span>{{ $craft->name }}</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  </button>
                </h2>
                <div id="accordion-open-body-{{$loop->iteration}}" class="hidden" aria-labelledby="accordion-open-heading-{{$loop->iteration}}">
                  <div class="p-2 font-light border {{$loop->last ? "border-t-0" : "border-b-0"}} border-gray-200">
                    <p class="mb-2 text-gray-500">{{ $craft->description }}</p>
                  </div>
                </div>
              @endforeach
              </div>
            @endif
          </div>
        @endif
      </div>
    @endif

    @if (count($character->perkVariants))
      @php
        $perks = $character->perkVariants->groupBy(function($item, $key) {
          return $item->perk->type->isCombat() ? 'combat' : 'noncombat';
        });
      @endphp
      <div class="flex justify-center gap-8">
        @if ($perks->get('combat'))
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-auto my-auto">
            <h1 class="font-bold text-xl mb-2">
              {{ __('perks.combat') }}
            </h1>
    
            <div class="space-y-4">
              @foreach ($perks->get('combat')->sortByDesc('active') as $perkVariant)
                @php
                  $perk = $perkVariant->perk
                @endphp
    
                <x-perk-card :character="$character" :perk="$perk" :perkVariant="$perkVariant" />
              @endforeach
            </div>
          </div>
        @endif
        @if ($perks->get('noncombat'))
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-auto my-auto">
            <h1 class="font-bold text-xl mb-2">
              {{ __('perks.noncombat') }}
            </h1>
    
            <div class="space-y-4">
              @foreach ($perks->get('noncombat')->sortByDesc('active') as $perkVariant)
                @php
                  $perk = $perkVariant->perk
                @endphp
    
                <x-perk-card :character="$character" :perk="$perk" :perkVariant="$perkVariant" />
              @endforeach
            </div>
          </div>
        @endif
      </div>
    @endif

    <x-form.error name="vox" />

    @can('updateCharsheetGm', $character)
      <div class="flex w-full justify-center">
        <a class="text-lg bg-white text-gray-700 py-2 px-3 rounded-full font-bold shadow align-self-center hover:bg-blue-100 focus:ring-2"
          href="{{ route('characters.perks.edit', $character) }}"
        >
          {{ __('charsheet.edit.perks') }}
        </a>
      </div>
    @endcan

    @can('seePlayerOnlyInfo', $character)
      @if (count($character->fates))
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify mx-auto w-max max-w-full">
          <h1 class="font-bold text-xl mb-2">
            {{ __('charsheet.fates') }}
          </h1>

          <div class="divide-y divide-dashed">
            @foreach ($character->fates as $fate)
              <div class="p-2">
                <div class="flex text-sm font-semibold space-x-2 mb-2">
                  @if ($fate->type->isDual())
                    <div class="bg-gray-200 px-2 rounded-full">
                      {{ __('fates.dual') }}
                    </div>
                  @elseif ($fate->type->hasFlag(App\Enums\FateType::Ambition))
                    <div class="bg-yellow-200 px-2 rounded-full">
                      {{ __('fates.ambition') }}
                    </div>
                  @elseif ($fate->type->hasFlag(App\Enums\FateType::Flaw))
                    <div class="bg-blue-200 px-2 rounded-full">
                      {{ __('fates.flaw') }}
                    </div>
                  @endif

                  @if ($fate->type->isOnetime())
                    <div class="bg-green-200 px-2 rounded-full">
                      {{ __('fates.onetime') }}
                    </div>
                  @else
                    <div class="bg-purple-200 px-2 rounded-full">
                      {{ __('fates.continious') }}
                    </div>
                  @endif
                </div>
                <div class="prose markdown text-lg min-w-full">{!! $fate->text !!}</div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endcan
    
    @can('updateCharsheetGm', $character)
      <div class="flex w-full justify-center">
        <a class="text-lg bg-white text-gray-700 py-2 px-3 rounded-full font-bold shadow align-self-center hover:bg-blue-100 focus:ring-2"
          href="{{ route('characters.fates.edit', $character) }}"
        >
          {{ __('charsheet.edit.fates') }}
        </a>
      </div>
    @endcan

    @can('seePlayerOnlyInfo', $character)
      @if ($character->player_only_info)
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
          <h1 class="font-bold text-xl mb-2">
            {{ __('label.player_only_info') }}
          </h1>

          <div class="prose markdown max-w-none">{!! $character->player_only_info !!}</div>
        </div>
      @endif
    @endcan
    
    @if ($character->gm_only_info)
      @can('seeGmOnlyInfo', $character)
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
          <h1 class="font-bold text-xl mb-2">
            {{ __('label.gm_only_info') }}
          </h1>

          <div class="prose markdown max-w-none">{!! $character->gm_only_info !!}</div>
        </div>
      @endcan
    @endif

    @can('seeBio', $character)
      @if ($character->personality)
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
          <h1 class="font-bold text-xl mb-2">
            {{ __('label.personality') }}
          </h1>

          <div class="prose markdown max-w-none">{!! $character->personality !!}</div>
        </div>
      @endif
      @if ($character->background)
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
          <h1 class="font-bold text-xl mb-2">
            {{ __('label.background') }}
          </h1>

          <div class="prose markdown max-w-none">{!! $character->background !!}</div>
        </div>
      @endif
    @endcan
  </x-container>
</x-app-layout>
