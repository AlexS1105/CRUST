<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="description"
                      maxlength="1024"
                      :value="old('description', @$advantage?->description)"
        />

        <x-form.input name="level"
                      type="number"
                      required
                      min="0"
                      max="100"
                      :value="old('level', @$advantage?->level)"
        />

        <x-form.checkbox name="is_penalty"
                         value="{{ old('is_penalty', @$advantage?->is_penalty ?? false) }}"
        />

        <x-button-submit/>
    </x-form.card>
</x-form.base>
