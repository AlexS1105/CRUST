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
          src="{{ asset($character->reference).'?='.$character->updated_at }}"
          alt="Character Reference"
        >
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
          @can('seeVisuals', $character)
            <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
              <h1 class="font-bold text-xl mb-2">
                {{ __('label.appearance') }}
              </h1>

              <div class="prose markdown max-w-none">{!! $character->appearance !!}</div>
            </div>
          @endcan
        @endif
      </div>
    </div>

    @if ($character->background)
      @can('seeBackground')
        <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
          <h1 class="font-bold text-xl mb-2">
            {{ __('label.background') }}
          </h1>

          <div class="prose markdown max-w-none">{!! $character->background !!}</div>
        </div>
      @endcan
    @endif
  </x-container>
</x-app-layout>
