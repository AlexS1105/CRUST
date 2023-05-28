@props(['name', 'accept' => false])

<x-form.field>
    <x-form.label name="{{ $name }}"/>

    <input
        {{ $attributes->merge(['class' => 'dark:text-gray-200 border border-gray-200 dark:border-gray-800 p-2 w-full rounded ' . ($attributes['readonly'] ? 'bg-gray-100 dark:bg-gray-500 opacity-75' : 'dark:bg-gray-700')]) }}
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes(['value' => old($name)]) }}
        {{ $accept ? 'accept='.$accept: '' }}
    />

    <x-form.error name="{{ $name }}"/>
</x-form.field>
