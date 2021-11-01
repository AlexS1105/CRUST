<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('characters.create') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('characters.store') }}" enctype="multipart/form-data">
      @csrf

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.main_info') }}
        </x-slot>

        <x-form.input name="name" maxlength="100" required placeholder="{{ __('characters.placeholder.name') }}" onchange="updateLoginField(this)" />
        <x-form.select required :name="'gender'" :values="App\Enums\CharacterGender::getKeys()" :labels="array_map(function($status) { return App\Enums\CharacterGender::fromValue($status)->localized(); }, App\Enums\CharacterGender::getValues())" :value="old('gender')" />
        <x-form.input name="race" maxlength="100" required placeholder="{{ __('characters.placeholder.race') }}" />
        <x-form.input name="age" maxlength="100" required placeholder="{{ __('characters.placeholder.age') }}" />
        <x-form.textarea name="description" maxlength="512" required onfocus="preview(this)" placeholder="{{ __('characters.placeholder.description') }}" wrap="off" />
        <x-form.checkbox name="info_hidden" value="{{ old('info_hidden', true) }}" />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.visuals') }}
        </x-slot>

        <x-form.input name="reference" type="file" accept="image/*" />
        <x-form.textarea name="appearance" maxlength="10000" required onfocus="preview(this)" placeholder="{{ __('characters.placeholder.appearance') }}" wrap="off" />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.biography') }}
        </x-slot>

        <x-form.textarea name="background" onfocus="preview(this)" placeholder="{{ __('characters.placeholder.background') }}" wrap="off" />
        <x-form.checkbox name="background_hidden" value="{{ old('background_hidden', true) }}" />
      </x-form.card>
      
      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.registration_info') }}
        </x-slot>

        <x-form.input name="login" required maxlength="16" pattern="[A-Za-z0-9-_]+" placeholder="{{ __('characters.placeholder.login') }}" />
      </x-form.card>
      
      <x-button>
        {{ __('ui.submit') }}
      </x-button>
    </form>
    <script>
      var previewText = @json(__('label.preview'))
    </script>
  </x-container>
</x-app-layout>
