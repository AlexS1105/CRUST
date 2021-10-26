<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center text-gray-600">
      <div class="flex-grow-0">
        <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
          {{ $user->name }}
        </h2>
        <div class="font-thin text-base mt-2">
          {{-- Discord: <span class="select-all">{{ $user->discord_tag }}</span> --}}
        </div>
      </div>
      <div class="flex flex-wrap flex-shrink-0">
        <x-user.actions :user="$user"/>
      </div>
    </div>
  </x-slot>
  
  @if (count($user->characters))
    <x-character.list :characters="$user->characters"/>
  @else
    <div class="text-gray-300 text-6xl text-center font-bold mt-40">
      {{ __('users.no_characters') }}
    </div>
  @endif
</x-app-layout>
