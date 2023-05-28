@extends('layouts.app')

@section('header', __('skins.index'))

@section('content')
    <x-container>
        <form class="space-y-8" method="POST" action="{{ route('characters.skins.store', $character) }}"
              enctype="multipart/form-data">
            @csrf

            <x-form.card>
                <x-form.input name="skins[]" type="file" accept="image/*" :value="old('skins')" multiple/>
                <div id="skins-list" class="grid grid-cols-2 gap-1 mx-auto">
                    <div class="hidden bg-gray-100 dark:bg-gray-600 border dark:border-gray-800 p-2">
                        <div class="text-gray-800 dark:text-gray-200 font-bold">{{ __('label.prefix') }}</div>
                        <input class="border h-8 p-1 text-sm w-full dark:bg-gray-700 dark:border-gray-800 dark:text-gray-300" type="text">
                        <img id="skin" class="mt-2 border dark:border-gray-800" src="#"/>
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
@endsection
