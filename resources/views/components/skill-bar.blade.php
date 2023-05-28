<div {{ $attributes->merge(['class' => 'flex font-bold gap-1 p-0.5 border-b bg-gray-50 dark:bg-gray-600 border-gray-200 dark:border-gray-700']) }}>
    <div class="text-xs bg-{{ $skill->stat->color() }}-200 dark:bg-{{ $skill->stat->color() }}-600 py-0.5 px-1 rounded-full">
        {{ $skill->stat->localized() }}
    </div>

    @if($skill->proficiency)
        <div class="text-xs bg-yellow-100 dark:bg-yellow-500 py-0.5 px-1 rounded-full">
            {{ __('skills.proficiency') }}
        </div>
    @endif

    {{ $slot }}
</div>
