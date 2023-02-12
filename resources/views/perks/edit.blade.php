@extends('layouts.app')

@section('header', __('perks.edit'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('perks.update', $perk) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="name" required maxlength="256" placeholder="{{ __('perks.placeholder.name') }}"
                              :value="old('name', $perk->name)"/>
                <x-form.input name="cost" type="number" required min="0" max="100" :value="old('cost', $perk->cost)"/>
                <x-form.textarea name="description" maxlength="5096" onfocus="preview(this)"
                                 placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
                    {{ old('description', $perk->description) }}
                </x-form.textarea>
                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection

@push('scripts')
    <script>
        var previewText = @json(__('label.preview'))
    </script>
@endpush
