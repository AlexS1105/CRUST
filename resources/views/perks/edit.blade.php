<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('perks.edit') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('perks.update', $perk) }}">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-form.input name="name" required maxlength="256" placeholder="{{ __('perks.placeholder.name') }}" :value="old('name', $perk->name)"/>
        <x-form.input name="cost" type="number" required value="{{ old('cost', $perk->cost) }}" min="0" max="50" placeholder="{{ __('perks.placeholder.name') }}" />
        <x-form.checkbox name="combat" value="{{ old('combat', $perk->type->hasFlag(App\Enums\PerkType::Combat)) }}" />
        <x-form.checkbox name="native" value="{{ old('native', $perk->type->hasFlag(App\Enums\PerkType::Native)) }}" />
        <x-form.checkbox name="unique" value="{{ old('unique', $perk->type->hasFlag(App\Enums\PerkType::Unique)) }}" />

        <x-button>
          {{ __('ui.submit') }}
        </x-button>
      </x-form.card>
    </form>
  </x-container>
</x-app-layout>
