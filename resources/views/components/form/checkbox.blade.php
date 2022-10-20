@props(['name', 'accept' => false])

<x-form.field>
    <div class="flex space-x-2">
        <input
            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block {{ $attributes['readonly'] ? 'bg-gray-100 opacity-75' : ''}}"
            name="{{ $name }}"
            id="{{ $name }}"
            type="checkbox"
            {{ ($attributes['value'] ?? old($name)) ? 'checked' : '' }}
            {{ $accept ? 'accept='.$accept: '' }}
        >

        <x-form.label name="{{ $name }}" class="font-normal"/>
    </div>

    <x-form.error name="{{ $name }}"/>
</x-form.field>
