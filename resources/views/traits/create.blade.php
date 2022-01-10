<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('traits.create') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('traits.store') }}">
      @csrf

      <x-form.card>
        <x-form.input name="name" required maxlength="256" placeholder="{{ __('traits.placeholder.name') }}" :value="old('name')" />
        <x-form.textarea name="description" maxlength="5096" required onfocus="preview(this)" placeholder="{{ __('traits.placeholder.description') }}" wrap="off">
          {{ old('description') }}
        </x-form.textarea>
        <x-form.textarea name="races" maxlength="2048" required placeholder="{{ __('traits.placeholder.races') }}" wrap="off" />
        <x-form.checkbox name="subtrait" value="{{ old('subtrait', false) }}" />

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
