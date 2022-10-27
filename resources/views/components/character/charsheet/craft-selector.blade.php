<div {{ $attributes->merge(['class' => 'rounded-2xl p-2 bg-' . $color . '-100']) }}>
    <div class="mb-1 text-center font-bold bg-{{ $color }}-300 rounded-full flex justify-center">
        <div class="mr-2">
            {{ __('charsheet.crafts.' . $craft) }}
        </div>
        @if ($craft != 'general')
            <div id="{{ $craft }}_points_spent">
                0
            </div>
            /
        @endif
        <div id="{{ $craft }}_points_max">
            {{ $craft != 'general' ? $character->charsheet->skills[$craft] : 0 }}
        </div>
    </div>
    <div class="space-y-1 px-1 pb-1">
        @foreach (call_user_func('App\Enums\CharacterCraft::get' . ucfirst($craft) . 'Crafts') as $instance)
            @php
                $craftValue = $instance->value;
                $value = old('crafts.'.$craftValue, $character->charsheet->crafts[$craftValue]);
                $max = $instance->getMaxTier();
            @endphp
            <div class="px-3 py-1 bg-{{ $color }}-200 rounded-lg">
                {{ $instance->localized() }}
                <div class="flex space-x-2">
                    <input class="w-full" type="range" id="crafts[{{ $craftValue }}]"
                           name="crafts[{{ $craftValue }}]" min="0" max="{{ $max }}" value="{{ $value }}"
                           oninput="updateCraftsSum(this)"/>
                    <output class="font-bold flex-none">{{ $value }}</output>
                </div>
            </div>
        @endforeach
    </div>
</div>
