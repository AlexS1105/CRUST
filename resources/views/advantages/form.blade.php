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

        <x-form.checkbox name="no_estitence_reduce_required"
                         value="{{ old('no_estitence_reduce_required', @$skill?->no_estitence_reduce_required ?? false) }}"
        />

        <x-button-submit/>
    </x-form.card>
</x-form.base>
