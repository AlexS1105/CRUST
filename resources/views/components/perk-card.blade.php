<div {{ $attributes->merge(['class' => 'border border-gray-400 rounded-xl bg-gray-100 overflow-hidden' . ($perkVariant->pivot->active ? '' : ' opacity-50'), 'data-accordion' => 'open', 'accordion' => false]) }}>
    <button
        id="perk-open-heading-{{ $perk->id }}"
        class="flex justify-between bg-gray-100 text-gray-500 border-gray-400 w-full items-center"
        data-accordion-target="#perk-open-body-{{ $perk->id }}"
        aria-expanded="{{ $accordion ? 'false' : 'true' }}"
        aria-controls="perk-open-body-{{ $perk->id }}"
        @disabled(! $accordion)
    >
        <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-1">
            {{ $perk->name }}
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
        <div
            class="flex bg-gray-50 border-b border-t border-gray-400 px-2 py-1 space-x-2 uppercase font-bold text-sm items-center">
            @if ($perk->isCombat())
                <div class="bg-red-100 px-2 rounded-full">
                    {{ __('perks.types.combat') }}
                </div>
            @else
                <div class="bg-green-100 px-2 rounded-full">
                    {{ __('perks.types.noncombat') }}
                </div>
            @endif

            @if ($perk->isAttack())
                <div class="bg-orange-100 px-2 rounded-full">
                    {{ __('perks.types.attack') }}
                </div>
            @endif

            @if ($perk->isDefence())
                <div class="bg-blue-200 px-2 rounded-full">
                    {{ __('perks.types.defence') }}
                </div>
            @endif

            @if ($perkVariant->pivot->active)
                <div class="bg-blue-100 px-2 rounded-full">
                    {{ __('perks.types.active') }}
                </div>
            @else
                <div class="bg-gray-300 px-2 rounded-full">
                    {{ __('perks.types.inactive') }}
                </div>
            @endif

            {{ $bar ?? '' }}
        </div>

        @if (isset($perk->general_description))
            <x-markdown class="p-2 min-w-full border-b bg-white">{!! $perk->general_description !!}</x-markdown>
        @endif

        <x-markdown class="p-2 min-w-full {{ isset($perk->general_description) ? 'bg-gray-50' : 'bg-white' }}">{!! $perkVariant->description !!}</x-markdown>
        @if($perkVariant->pivot->note)
            <div class="px-2 py-1 border-t bg-gray-50 italic">
                {{ $perkVariant->pivot->note }}
            </div>
        @endif
    </div>
</div>
