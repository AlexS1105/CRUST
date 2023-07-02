@props([
    'skill',
])

<div {{ $attributes->merge(['class' => 'flex font-bold gap-1 p-0.5 border-b bg-gray-50 dark:bg-gray-600 border-gray-200 dark:border-gray-700']) }}>
    <div class="text-xs bg-{{ $skill->stat->color() }}-200 dark:bg-{{ $skill->stat->color() }}-600 py-0.5 px-1 rounded-full">
        <div class="dark:drop-shadow-xs">
            {{ $skill->stat->localized() }}
        </div>
    </div>

    @if($skill->proficiency)
        <div class="text-xs bg-yellow-100 dark:bg-yellow-500 py-0.5 px-1 rounded-full">
            <div class="dark:drop-shadow-xs">
                {{ __('skills.proficiency') }}
            </div>
        </div>
    @endif

    {{ $slot }}
</div>
