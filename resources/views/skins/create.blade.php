<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('skins.index') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('characters.skins.store', $character) }}"
              enctype="multipart/form-data">
            @csrf

            <x-form.card>
                <x-form.input name="prefix" maxlength="100" :value="old('prefix')"/>
                <x-tip>
                    {{ __('tips.skins.prefix') }}
                </x-tip>
                <x-form.input name="skin" type="file" accept="image/*" :value="old('skin')"/>
                <x-tip>
                    {{ __('tips.skins.skin') }}
                </x-tip>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
