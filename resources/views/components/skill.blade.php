<div {{ $attributes->merge(['class' => 'border border-gray-400 rounded-xl overflow-hidden']) }}>
    <div class="flex justify-between border-b bg-gray-100 border-gray-400">
        <div class="flex items-center font-bold text-lg uppercase space-x-2">
            <div class="p-2 text-lg uppercase flex gap-2 items-center">
                {{ $skill->name }}
            </div>

            {{ $name ?? null }}
        </div>
    </div>
    <div class="flex font-bold gap-1 p-0.5 border-b bg-gray-50 border-gray-400">
        <div class="text-xs bg-{{ $skill->stat->color() }} py-0.5 px-1 rounded-full">
            {{ $skill->stat->localized() }}
        </div>

        @if($skill->proficiency)
            <div class="text-xs bg-yellow-100 py-0.5 px-1 rounded-full">
                {{ __('skills.proficiency') }}
            </div>
        @endif

        {{ $bar ?? null }}
    </div>
    <div class="divide-y divide-dashed">
        @if (isset($skill->description))
            <div class="flex items-center p-2 space-x-2 justify-between">
                {{ $skill->description }}
            </div>
        @endif
    </div>

    {{ $slot ?? null }}
</div>
