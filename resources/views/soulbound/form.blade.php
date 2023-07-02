<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="name"
                      maxlength="256"
                      required
                      :value="old('name', @$soulbound?->name)"
        />

        <x-form.input name="cost" type="number" required min="0" max="100" :value="old('cost', @$soulbound?->cost)"/>

        <x-form.textarea name="description"
                         maxlength="5096"
                         required
                         onfocus="preview(this)"
                         wrap="off"
        >
            {{ old('description', @$soulbound?->description) }}
        </x-form.textarea>
    </x-form.card>

    <x-button-submit/>
</x-form.base>

@push('scripts')
    <script>
        var previewText = @json(__('label.preview'))
    </script>
@endpush
