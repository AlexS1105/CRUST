@props(['name', 'accept' => false])

<x-form.field>
  <div class="flex space-x-2">
    <input class="block {{ $attributes['readonly'] ? 'bg-gray-100 opacity-75' : ''}}"
        name="{{ $name }}"
        id="{{ $name }}"
        type="checkbox"
        {{ $attributes(['value' => old($name)]) }}
        {{ $accept ? 'accept='.$accept: '' }}
      >

    <x-form.label name="{{ $name }}" />
  </div>

  <x-form.error name="{{ $name }}"/>
</x-form.field>
