<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="name"
                      required
                      maxlength="256"
                      :value="old('name', @$technique?->name)"
        />

        <x-form.textarea name="description" maxlength="5096" onfocus="preview(this)" wrap="off">
            {{ old('description', @$technique?->description) }}
        </x-form.textarea>

        <x-button-submit/>
    </x-form.card>
</x-form.base>

@push('scripts')
    <script>
        var previewText = @json(__('label.preview'))
    </script>
@endpush
