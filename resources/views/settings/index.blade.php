<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Settings') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-6xl space-y-8">
    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6">
      <a href="{{ route('settings.general.show') }}">General Settings</a>
    </div>
  </x-container>
</x-app-layout>
