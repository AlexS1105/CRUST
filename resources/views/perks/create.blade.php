<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('perks.create') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('perks.store') }}">
            @csrf

            <x-form.card>
                <x-form.input name="name" required maxlength="256" placeholder="{{ __('perks.placeholder.name') }}"
                              :value="old('name')"/>
                <x-form.textarea name="general_description" maxlength="5096" onfocus="preview(this)"
                                 placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
                    {{ old('general_description') }}
                </x-form.textarea>
                <x-form.textarea name="description" maxlength="5096" required onfocus="preview(this)"
                                 placeholder="{{ __('perks.placeholder.description') }}" wrap="off">
                    {{ old('description') }}
                </x-form.textarea>
                <x-form.checkbox name="combat" value="{{ old('combat', false) }}"/>
                <x-form.checkbox name="attack" value="{{ old('attack', false) }}"/>
                <x-form.checkbox name="defence" value="{{ old('defence', false) }}"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
        <script>
            var previewText = @json(__('label.preview'))
        </script>
    </x-container>
</x-app-layout>
