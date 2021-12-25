<div class="flex justify-between text-lg uppercase">
  <x-character-stage-link
    href="{{ isset($character) ? route('characters.edit', $character->login) : '#' }}"
    :active="request()->routeIs('characters.edit') || request()->routeIs('characters.create')"
    :disabled="!isset($character) || request()->routeIs('characters.edit') || request()->routeIs('characters.create')">
    {{ __('characters.stages.main') }}
  </x-character-stage-link>
  <x-character-stage-link
    href="{{ isset($character) ? route('characters.charsheet.edit', $character->login) : '#' }}"
    :active="request()->routeIs('characters.charsheet.edit')"
    :disabled="!isset($character) || request()->routeIs('characters.charsheet.edit')">
    {{ __('characters.stages.charsheet') }}
  </x-character-stage-link>
</div>
