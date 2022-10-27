@extends('layouts.app')

@section('header', __('perks.variants.create'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('perks.variants.store', $perk) }}">
            @csrf

            <x-form.card>
                <x-form.textarea name="description" maxlength="5096" required onfocus="preview(this)"
                                 placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
                    {{ old('description') }}
                </x-form.textarea>

                <x-button-submit/>
            </x-form.card>
        </form>
        <script>
            var previewText = @json(__('label.preview'))
        </script>
    </x-container>
@endsection
