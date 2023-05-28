@props(['name'])

<x-form.field>
    <x-form.label name="{{ $name }}"/>

    <textarea
        class="dark:text-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-800 p-2 w-full rounded"
        name="{{ $name }}"
        id="{{ $name }}"
    {{ $attributes }}
  >{{ $slot->isNotEmpty() ? $slot : old($name) }}</textarea>

    <x-form.error name="{{ $name }}"/>
</x-form.field>
