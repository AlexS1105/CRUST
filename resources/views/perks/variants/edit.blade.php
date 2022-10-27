@extends('layouts.app')

@section('header', __('perks.variants.edit'))

@section('content')
        <form class="space-y-8" method="POST"
              action="{{ route('perks.variants.update', ['perk' => $perk, 'variant' => $variant]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.textarea name="description" maxlength="5096" required onfocus="preview(this)"
                                 placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
                    {{ old('description', $variant->description) }}
                </x-form.textarea>

                <x-button-submit/>
            </x-form.card>
        </form>
        <script>
            var previewText = @json(__('label.preview'))
        </script>
    </x-container>
@endsection
