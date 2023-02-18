<div {{ $attributes->merge(['class' => 'flex font-bold gap-1 p-0.5 border-b bg-gray-50 border-gray-400']) }}>
    <div class="text-xs bg-{{ $skill->stat->color() }} py-0.5 px-1 rounded-full">
        {{ $skill->stat->localized() }}
    </div>

    @if($skill->proficiency)
        <div class="text-xs bg-yellow-100 py-0.5 px-1 rounded-full">
            {{ __('skills.proficiency') }}
        </div>
    @endif

    {{ $slot }}
</div>
