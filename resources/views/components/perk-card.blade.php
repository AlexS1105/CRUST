@props([
    'character',
    'perk',
    'accordion',
])

<div {{ $attributes->merge(['class' => 'border border-gray-400 dark:border-gray-900 dark:bg-gray-700 rounded-xl bg-gray-100 dark:bg-gray-900 overflow-hidden', 'data-accordion' => 'open', 'accordion' => false]) }}>
    <button
        id="perk-open-heading-{{ $perk->id }}"
        class="flex justify-between text-gray-500 dark:text-gray-200 dark:bg-gray-700 border-gray-400 dark:border-gray-900 w-full items-center"
        data-accordion-target="#perk-open-body-{{ $perk->id }}"
        aria-expanded="{{ $accordion ? 'false' : 'true' }}"
        aria-controls="perk-open-body-{{ $perk->id }}"
        @disabled(! $accordion)
    >
        <div class="flex items-center font-bold text-lg uppercase space-x-2 dark:border-gray-900">
            <div class="p-2 border-r border-gray-400 dark:border-gray-900">
                {{ $perk->cost }}
            </div>
            <div class="p-2 text-lg uppercase">
                {{ $perk->name }}
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

    <div id="perk-open-body-{{ $perk->id }}" class="hidden" aria-labelledby="perk-open-heading-{{ $perk->id }}">
        @if (isset($perk->description))
            <x-markdown class="p-2 min-w-full bg-white dark:bg-gray-600 dark:text-gray-300 border-t border-gray-400 dark:border-gray-900">{!! $perk->description !!}</x-markdown>
        @endif

        @if($perk->pivot?->note)
            <div class="px-2 py-1 border-t dark:border-gray-900 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 italic">
                {{ $perk->pivot->note }}
            </div>
        @endif
    </div>
</div>
