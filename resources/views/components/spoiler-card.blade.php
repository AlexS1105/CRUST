@props([
    'id',
    'type',
])

<div {{ $attributes->merge(['class' => 'border border-gray-400 dark:border-gray-900 dark:bg-gray-700 rounded-xl bg-gray-100 dark:bg-gray-900 overflow-hidden', 'data-accordion' => 'open', 'accordion' => false]) }}>
    <button
        id="{{ $type }}-open-heading-{{ $id }}"
        class="flex justify-between text-gray-500 dark:text-gray-200 dark:bg-gray-700 border-gray-400 dark:border-gray-900 w-full items-center"
        data-accordion-target="#{{ $type }}-open-body-{{ $id }}"
        aria-expanded="false"
        aria-controls="{{ $type }}-open-body-{{ $id }}"
    >
        <div class="p-2 text-lg uppercase flex items-center font-bold text-lg uppercase space-x-2 dark:border-gray-900">
            {{ $header }}
        </div>

        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
        </svg>
    </button>

    <div id="{{ $type }}-open-body-{{ $id }}" class="hidden" aria-labelledby="{{ $type }}-open-heading-{{ $id }}">
        {{ $slot }}
    </div>
</div>
