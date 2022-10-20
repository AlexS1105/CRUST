<div {{ $attributes->merge(['class' => 'perk-open border border-gray-400 rounded-xl bg-gray-100 overflow-hidden max-w-fit'.($perkVariant->pivot->active ? '' : ' opacity-50'), 'data-accordion' => 'open']) }}>
    <button
        id="perk-open-heading-{{ $perk->id }}"
        class="flex justify-between bg-gray-100 text-gray-500 border-gray-400 w-full items-center"
        data-accordion-target="#perk-open-body-{{ $perk->id }}"
        aria-expanded="false"
        aria-controls="perk-open-body-{{ $perk->id }}"
    >
        <div class="flex items-center font-bold text-lg py-2 px-3 uppercase space-x-1">
            <div>
                {{ $perk->name }}
            </div>
        </div>
        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
        </svg>
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
            @can('togglePerks', $character)
                @if($character->vox > 1 && !$perkVariant->pivot->active || $perkVariant->pivot->active)
                    <form method="POST"
                          action="{{ route('characters.perks.toggle', ['character' => $character, 'perkVariant' => $perkVariant]) }}">
                        @csrf
                        @method('PATCH')

                        <a
                            class="cursor-pointer text-blue-600"
                            onclick="if (confirm('{{ __('ui.confirm', ['tip' => __('tips.perk.'.($perkVariant->pivot->active ? 'deactivation' : 'activation'))]) }}')) {
                event.preventDefault();
                this.closest('form').submit();
              }"
                            title="{{ __('perks.'.($perkVariant->pivot->active ? 'deactivate' : 'activate')) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                @if ($perkVariant->pivot->active)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </a>
                    </form>
                @endif
            @endcan
        </div>
        @if (isset($perk->general_description))
            <div class="prose markdown p-2 min-w-full border-b bg-white">{!! $perk->general_description !!}</div>
        @endif
        <div
            class="prose markdown p-2 min-w-full {{isset($perk->general_description) ? "bg-gray-50" : "bg-white"}}">{!! $perkVariant->description !!}</div>
        @if($perkVariant->pivot->note)
            <div class="px-2 py-1 border-t bg-gray-50 italic">
                {{ $perkVariant->pivot->note }}
            </div>
        @endif
    </div>
</div>
