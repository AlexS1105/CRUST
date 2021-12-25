<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('settings.index') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-3xl">
    <form method="POST" action="{{ route('settings.charsheet.update') }}">
      @csrf
      @method('PATCH')
      
      <x-form.card>
          <x-form.input name="skill_points" type="number" min="0" max="100" :value="old('skill_points', $settings->skill_points)"/>
          <x-form.input name="perk_points" type="number" min="0" max="100" :value="old('perk_points', $settings->perk_points)"/>

          <x-button>
            {{ __('ui.submit') }}
          </x-button>
      </x-form.card>
    </form>
  </x-container>
</x-app-layout>
