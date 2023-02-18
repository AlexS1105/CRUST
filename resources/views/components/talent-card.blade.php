<div {{ $attributes->merge(['class' => 'border border-gray-400 rounded-xl bg-gray-100 overflow-hidden', 'data-accordion' => 'open', 'accordion' => false]) }}>
    <button
        id="talent-open-heading-{{ $talent->id }}"
        class="flex justify-between bg-gray-100 text-gray-500 border-gray-400 w-full items-center"
        data-accordion-target="#talent-open-body-{{ $talent->id }}"
        aria-expanded="{{ $accordion ? 'false' : 'true' }}"
        aria-controls="talent-open-body-{{ $talent->id }}"
        @disabled(! $accordion)
    >
        <div class="flex items-center font-bold text-lg uppercase space-x-2">
            <div class="p-2 border-r border-gray-400">
                {{ $talent->cost }}
            </div>
            <div class="p-2 text-lg uppercase">
                {{ $talent->name }}
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

    <div id="talent-open-body-{{ $talent->id }}" class="hidden" aria-labelledby="talent-open-heading-{{ $talent->id }}">
        @if (isset($talent->description))
            <x-markdown class="p-2 min-w-full bg-white border-t border-gray-400">{!! $talent->description !!}</x-markdown>
        @endif
    </div>
</div>
