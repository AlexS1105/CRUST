<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('perks.variants.create') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('perks.variants.store', $perk) }}">
      @csrf

      <x-form.card>
        <x-form.textarea name="description" maxlength="1024" required onfocus="preview(this)" placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
          {{ old('description') }}
        </x-form.textarea>

        <x-button>
          {{ __('ui.submit') }}
        </x-button>
      </x-form.card>
    </form>
    <script>
      var previewText = @json(__('label.preview'))
    </script>
  </x-container>
</x-app-layout>
