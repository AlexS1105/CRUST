@props([
    'character',
    'technique',
    'accordion',
])

<div {{ $attributes->merge(['class' => 'border border-gray-400 dark:border-gray-900 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden', 'data-accordion' => 'open', 'accordion' => false]) }}>
    <button
        id="technique-open-heading-{{ $technique->id }}"
        class="flex justify-between bg-gray-100 dark:bg-gray-700 dark:bg-gray-600 text-gray-500 dark:text-gray-200 border-gray-400 dark:border-gray-900 w-full items-center"
        data-accordion-target="#technique-open-body-{{ $technique->id }}"
        aria-expanded="{{ $accordion ? 'false' : 'true' }}"
        aria-controls="technique-open-body-{{ $technique->id }}"
        @disabled(! $accordion)
    >
        <div class="flex items-center font-bold text-lg uppercase space-x-2">
            <div class="p-2 text-lg uppercase">
                {{ $technique->name }}
            </div>

            {{ $name ?? null }}
        </div>

        @if ($accordion)
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
            </svg>
        @endif
    </button>

    <div id="technique-open-body-{{ $technique->id }}" class="hidden" aria-labelledby="technique-open-heading-{{ $technique->id }}">
        @if (isset($technique->description))
            <x-markdown class="p-2 min-w-full bg-white dark:bg-gray-600 dark:text-gray-300 border-t border-gray-400 dark:border-gray-900">{!! $technique->description !!}</x-markdown>
        @endif
    </div>
</div>
