<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('charsheet.edit') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('characters.charsheet.update', $character->login) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.skills') }}
        </x-slot>

        <div class="grid gap-2 grid-cols-6">
          @foreach($character->charsheet->skills as $skill => $value)
            <div class="col-span-2 text-lg text-right mr-4">
              {{ __('skill.'.$skill) }}
            </div>
            <div class="col-span-4 space-x-4 flex">
              <input class="w-full" type="range" id="skills[{{ $skill }}]" name="skills[{{ $skill }}]" min="0" max="10" value="{{ $value }}" oninput="this.nextElementSibling.value = this.value"/>
              <output class="font-bold text-xl flex-none">{{ $value }}</output>
            </div>
          @endforeach
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.crafts') }}
        </x-slot>


      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.perks') }}
        </x-slot>


      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.trait') }}
        </x-slot>


      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('charsheet.fates') }}
        </x-slot>


      </x-form.card>

      <x-button>
        {{ __('ui.submit') }}
      </x-button>
    </form>
  </x-container>
</x-app-layout>
