<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="name"
                      maxlength="256"
                      required
                      :value="old('name', @$attunement?->name)"
        />

        <x-form.textarea name="description"
                         maxlength="5096"
                         required
                         onfocus="preview(this)"
                         wrap="off"
        >
            {{ old('description', @$attunement?->description) }}
        </x-form.textarea>
    </x-form.card>

    <x-button-submit/>
</x-form.base>

@push('scripts')
    <script>
        var previewText = @json(__('label.preview'))
    </script>
@endpush
