<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.textarea name="text"
                         maxlength="512"
                         required
                         placeholder="{{ __('rumors.placeholder') }}"
                         wrap="off"
        >
            {{ old('text', @$rumor?->text) }}
        </x-form.textarea>
        <x-tip text="rumors.text"/>
        <x-form.select required
                       :name="'tide'"
                       :values="App\Enums\Tide::cases()"
                       :labels="array_map(function($tide) { return $tide->localized(); }, App\Enums\Tide::cases())"
                       :value="old('tide', @$rumor?->tide)"
        />
        <x-tip text="rumors.tide"/>
    </x-form.card>

    <x-button-submit/>
</x-form.base>
