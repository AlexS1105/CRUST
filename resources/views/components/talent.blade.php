<div {{ $attributes->merge(['class' => 'border border-gray-400 rounded-xl overflow-hidden']) }}>
    <div class="flex justify-between border-b bg-gray-100 border-gray-400">
        <div class="flex items-center font-bold text-lg uppercase space-x-2">
            <div class="p-2 text-lg uppercase flex gap-2 items-center">
                {{ $talent->name }}
            </div>

            {{ $name ?? null }}
        </div>
    </div>
    <div class="divide-y divide-dashed">
        @if (isset($talent->description))
            <div class="flex items-center p-2 space-x-2 justify-between">
                {{ $talent->description }}
            </div>
        @endif
    </div>

    {{ $slot ?? null }}
</div>
