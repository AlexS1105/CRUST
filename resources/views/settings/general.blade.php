<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('General Settings') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-6xl space-y-8">
    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6">
      <form method="POST" action="{{ route('settings.general.update') }}">
        @csrf
        @method('PATCH')

        <x-form.input name="start_points" type="number" min="0" max="100" :value="old('start_points', $settings->start_points)"/>
        <x-form.input name="max_characters" type="number" min="0" max="100" :value="old('max_characters', $settings->max_characters)"/>

        <x-button>
          Submit
        </x-button>
      </form>
    </div>
  </x-container>
</x-app-layout>
