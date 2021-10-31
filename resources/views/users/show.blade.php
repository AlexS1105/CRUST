<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center text-gray-600">
      <div class="flex-grow-0">
        <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
          {{ $user->login }}
        </h2>
        <div class="font-thin text-base mt-2">
          Discord: <span class="select-all">{{ $user->discord_tag }}</span>
        </div>
      </div>
      <div class="flex flex-wrap flex-shrink-0">
        <x-user.actions :user="$user"/>
      </div>
    </div>
  </x-slot>

  @if ($user->ban)
    <x-card class="bg-yellow-100 mt-4 mx-auto max-w-7xl">
      <div class="flex items-center space-x-4">
        <div class="fa fa-gavel text-7xl text-gray-800"></div>
        <div class="min-w-auto">
          <div class="font-bold text-lg">
            {{ __('ban.title', [ 'user' => $user->login, 'admin' => $user->ban->by->login ]) }}
          </div>
          <div>
            {{ __('label.reason') }}: {{ $user->ban->reason }}
          </div>
          <div>
            {{ __('label.expires') }} {{ Carbon\Carbon::parse($user->ban->expires)->diffForHumans() }} ({{ $user->ban->expires }})
          </div>
        </div>
      </div>
    </x-card>
  @endif
  
  @if (count($user->characters))
    <x-character.list :characters="$user->characters"/>
  @else
    <div class="text-gray-300 text-6xl text-center font-bold mt-40">
      {{ __('users.no_characters') }}
    </div>
  @endif
</x-app-layout>
