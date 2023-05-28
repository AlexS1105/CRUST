@php
    $characterSkill = $character->skills->firstWhere('id', $skill->id);
    $stat = $character->charsheet->stats[$skill->stat->value];
    $bonus = $stat;
    $level = 0;
    $skillTaken = $characterSkill != null;

    if ($skillTaken) {
        $skill = $characterSkill;
        $bonus = $characterSkill->pivot->bonus;
        $level = $skill->pivot->level;
    }
@endphp

<x-accordion-item id="skill-{{ $skill->id }}" :loop="$loop">
    <x-slot name="title">
        <div class="flex">
            {{ $skill->name }} ({{ $bonus }})
            @if($skillTaken)
                -&nbsp;<div class="font-bold">{{ __('skills.level.' . $level) }}</div>
            @endif
        </div>
    </x-slot>

    <x-slot name="body">
        <x-skill-bar class="border-gray-200 dark:border-gray-800" :skill="$skill" />

        <ul class="py-0.5 px-1 bg-gray-50 dark:bg-gray-600 border-b border-gray-200 dark:border-gray-400 text-sm">
            <span>
                {{ __('skills.level.title') }}:
                <b>
                    {{ __('skills.level.' . $level) }}
                </b>

                @if($skillTaken)
                    ({{ $skill->pivot->cost }})
                @endif
            </span>
            <hr class="my-1 dark:border-gray-400">
            <div>
                {{ $skill->stat->localized() }}:
                <b>+{{ $stat }}</b>
            </div>
            @if($skillTaken && $skill->pivot->level >= 2)
                <div>
                    {{ __('skills.soul_coefficient') }}:
                    <b>+{{ $character->soul_coefficient }}</b>
                </div>
            @endif

            @if($skillTaken && ($skill->pivot->level == 1 || $skill->pivot->level == 3))
                <div>
                    {{ __('skills.level.bonus') }}:
                    <b>+{{ $skill->pivot->level }}</b>
                </div>
            @endif
        </ul>
    </x-slot>

    <x-slot name="content">
        <div>{{ $skill->description }}</div>
    </x-slot>

    @if($skill->advantages->isNotEmpty())
        <div class="divide-y divide-dashed divide-gray-300 bg-gray-100 dark:bg-gray-600 border-t border-dashed border-gray-300">
            @foreach($skill->advantages as $advantage)
                @continue($advantage->is_penalty && $bonus > $advantage->level || $bonus < $advantage->level && !$advantage->is_penalty)

                <div class="{{ $advantage->is_penalty ? 'bg-red-100 dark:bg-red-500' : 'bg-gray-100 dark:bg-gray-700' }} grid grid-cols-12 grid-flow-col items-center">
                    <div class="col-span-1 text-center font-bold text-lg">{{ $loop->first ? '<=' : '' }} {{ $advantage->level }} {{ $loop->last ? '<=' : '' }}</div>
                    <div class="p-2 col-span-10 border-l border-dashed border-gray-300">{{ $advantage->description }}</div>
                </div>
            @endforeach
        </div>
    @endif
</x-accordion-item>
