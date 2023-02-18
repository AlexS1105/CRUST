<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="name"
                      required
                      maxlength="256"
                      :value="old('name', @$talent?->name)"
        />

        <x-form.input name="description"
                      maxlength="1024"
                      :value="old('description', @$talent?->description)"
        />

        <x-form.input name="cost"
                      type="number"
                      required
                      min="0"
                      max="100"
                      :value="old('cost', @$talent->cost)"
        />
        <x-button-submit/>
    </x-form.card>
</x-form.base>
