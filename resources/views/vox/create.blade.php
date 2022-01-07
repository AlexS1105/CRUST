<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('vox.index') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('characters.vox.store', $character) }}">
      @csrf

      <x-form.card>
        <x-form.input name="reason" required maxlength="256" :value="old('reason')" />
        <x-form.input name="delta" required type="number" min="-100" max="100" :value="old('delta')"/>

        <x-button>
          {{ __('ui.submit') }}
        </x-button>
      </x-form.card>
    </form>
  </x-container>
</x-app-layout>
