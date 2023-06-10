<div {{ $attributes->merge(['class' => 'dark:text-gray-200 border border-gray-400 dark:border-gray-900 rounded-xl overflow-hidden']) }}>
    <div class="flex justify-between border-b bg-gray-100 dark:bg-gray-800 border-gray-400 dark:border-gray-900">
        <div class="flex items-center font-bold text-lg uppercase space-x-2">
            <div class="p-2 text-lg uppercase flex gap-2 items-center">
                {{ $skill->name }}
            </div>

            {{ $name ?? null }}
        </div>
    </div>
    <x-skill-bar :skill="$skill">
        {{ $bar ?? null }}
    </x-skill-bar>
    <div class="divide-y divide-dashed divide-gray-400 dark:divide-gray-800">
        @if (isset($skill->description))
            <div class="flex items-center p-2 space-x-2 justify-between">
                {{ $skill->description }}
            </div>
        @endif

        @foreach($skill->advantages as $advantage)
            <div class="{{ $advantage->is_penalty ? 'bg-red-100 dark:bg-red-500' : ($advantage->titled ? 'bg-yellow-100 dark:bg-yellow-500' : 'bg-gray-100 dark:bg-gray-700') }} grid grid-cols-12 grid-flow-col items-center">
                <div class="col-span-1 text-center font-bold text-lg">
                    {{ $loop->first ? '<=' : '' }} {{ $advantage->level }} {{ $loop->last ? '<=' : '' }}

                    @if($advantage->titled)
                        <div class="font-light text-xs text-yellow-700 dark:text-yellow-200">
                            {{ __('skills.titled') }}
                        </div>
                    @endif
                </div>
                <div class="p-2 col-span-10 border-l border-dashed border-gray-400 dark:border-gray-900">{{ $advantage->description }}</div>

                {{ ${'advantage_' . $advantage->id} ?? null }}
            </div>
        @endforeach

        {{ $list ?? null }}
    </div>

    {{ $slot ?? null }}
</div>
