<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create New Character') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('characters.store') }}" enctype="multipart/form-data">
      @csrf

      <x-form.card>
        <x-slot name="header">
          Main Info
        </x-slot>

        <x-form.input name="name" maxlength="100" required />
        <x-form.select required :name="'gender'" :values="App\Enums\CharacterGender::getKeys()" :value="old('gender')"/>
        <x-form.input name="race" maxlength="100" required />
        <x-form.input name="age" maxlength="100" required />
        <x-form.textarea name="description" maxlength="512" required />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          Visuals
        </x-slot>

        <x-form.input name="reference" type="file" accept="image/*" />
        <x-form.textarea name="appearance" maxlength="10000" required />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          Biography
        </x-slot>

        <x-form.textarea name="background" />
      </x-form.card>
      
      <x-form.card>
        <x-slot name="header">
          Registration Info
        </x-slot>

        <x-form.input name="login" required maxlength="16" pattern="[A-Za-z0-9-_]+"/>

        <x-button>
          Submit
        </x-button>
      </x-form.card>
    </form>
    <script src="{{ asset('js/character.js') }}"></script>
  </x-container>
</x-app-layout>
