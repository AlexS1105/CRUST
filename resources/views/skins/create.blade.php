<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('skins.index') }}
        </h2>
    </x-slot>

    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('characters.skins.store', $character) }}"
              enctype="multipart/form-data">
            @csrf

            <x-form.card>
                <x-form.input name="skins[]" type="file" accept="image/*" :value="old('skins')" multiple/>
                <div id="skins-list" class="grid grid-cols-2 gap-1 mx-auto">
                    <div class="hidden bg-gray-100 border p-2">
                        <div class="text-gray-800 font-bold">{{ __('label.prefix') }}</div>
                        <input class="border h-8 p-1 text-sm w-full" type="text">
                        <img id="skin" class="mt-2 border" src="#"/>
                    </div>
                </div>
                <x-tip>
                    {{ __('tips.skins.skin') }}
                </x-tip>
                <x-tip>
                    {{ __('tips.skins.prefix') }}
                </x-tip>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
