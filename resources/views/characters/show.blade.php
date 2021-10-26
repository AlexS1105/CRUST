<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center text-gray-600">
      <div class="flex-grow-0">
        <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
          {{ $character->name }}
        </h2>
        <div class="font-thin text-base">
          Player: <a @can('view', $character->user)
            class="font-bold underline text-blue-600 visited:text-purple-600"
            href="{{ route('users.show', $character->user) }}"
          @endcan>{{ $character->user->login }}</a>
        </div>
        <div class="font-thin text-base">
          Discord: <span class="select-all">{{ $character->user->discord_tag }}</span>
        </div>
        <div class="font-thin text-base">
          Login: <span class="select-all">{{ $character->login }}</span>
        </div>
      </div>
      <div class="flex flex-wrap flex-shrink-0">
        <x-application.actions :character="$character"/>
      </div>
      <div>
        <div class="flex items-center gap-4 font-bold text-xl">
          Status: <x-character.status :status="$character->status"/>
        </div>
        @if ($character->registrar)
          <div class="font-thin text-base text-right mt-2">
            Registrar: {{ $character->registrar->discord_tag }}
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
        <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
          <h1 class="font-bold text-xl mb-2">
            Info
          </h1>
  
          <div class="text-lg">
            <div class="flex items-center gap-1">
              <b>Gender:</b> 
              {{ $character->gender->description }}
              <div class="text-2xl fa {{ $character->gender->icon() }} text-{{ $character->gender->color() }}"></div>
            </div>
            <div>
              <b>Race:</b> {{ $character->race }}
            </div>
            <div>
              <b>Age:</b> {{ $character->age }}
            </div>
          </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
          <h1 class="font-bold text-xl my-2">
            Description
          </h1>
  
          @markdown($character->description)
        </div>

        @if ($character->appearance)
          <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
            <h1 class="font-bold text-xl mb-2">
              Appearance
            </h1>

            @markdown($character->appearance)
          </div>
        @endif
      </div>
    </div>

    @if ($character->background)
      <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
        <h1 class="font-bold text-xl mb-2">
          Background
        </h1>

        @markdown($character->background)
      </div>
    @endif
  </x-container>
</x-app-layout>
