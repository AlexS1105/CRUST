<x-container>
    <x-form.base action="{{ $action }}" :method="$method">
        <x-form.card>
            <x-form.input name="name"
                          required
                          maxlength="256"
                          :value="old('name', @$narrativeCraft?->name)"
            />

            <x-form.input name="description"
                          maxlength="1024"
                          :value="old('description', @$narrativeCraft?->description)"
            />

            <x-button-submit/>
        </x-form.card>
    </x-form.base>
</x-container>
