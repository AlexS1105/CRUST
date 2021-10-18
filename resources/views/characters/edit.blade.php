<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Character') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('characters.update', $character->login) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-slot name="header">
          Main Info
        </x-slot>

        <x-form.input name="name" maxlength="100" required :value="old('name', $character->name)"/>
        <x-form.select required :name="'gender'" :values="App\Enums\CharacterGender::getKeys()" :value="old('gender', $character->gender->description)"/>
        <x-form.input name="race" maxlength="100" required :value="old('race', $character->race)" />
        <x-form.input name="age" maxlength="100" required :value="old('age', $character->age)"/>
        <x-form.textarea name="description" maxlength="512" required>
          {{ old('description', $character->description) }}
        </x-form.textarea>
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          Visuals
        </x-slot>

        <x-form.input name="reference" type="file" accept="image/*" />
        <x-form.textarea name="appearance" maxlength="10000" required>
          {{ old('appearance', $character->appearance) }}
        </x-form.textarea>
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          Biography
        </x-slot>

        <x-form.textarea name="background">
          {{ old('background', $character->background) }}
        </x-form.textarea>
      </x-form.card>

      <x-button>
        Save
      </x-button>
    </form>
  </x-container>
</x-app-layout>
