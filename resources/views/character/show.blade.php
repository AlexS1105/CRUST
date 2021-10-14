<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-600">
            <div>
                <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                    {{ $character->name }}
                </h2>
                <div class="font-thin text-base mt-2">
                    Login: {{ $character->login }}
                </div>
            </div>
            <div>
                <div class="flex items-center gap-4 font-bold text-xl">
                    Status: <x-character-status :status="$character->status"/>
                </div>
                @if ($character->registrar)
                    <div class="font-thin text-base text-right mt-2">
                        Registrar: {{ $character->registrar->name }}
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto space-y-8">
        <div class="grid grid-cols-2 grid-rows-3 gap-4">
            <div class="bg-white rounded-xl max-w-md mx-auto shadow-lg row-span-3 place-self-start ">
                <img
                    class="object-cover"
                    src="{{ $character->getReference(); }}"
                    alt="Character Reference"
                >
            </div>
            <div class="bg-white p-4 rounded-xl shadow-lg place-self-center">
                <h1 class="font-bold text-xl mb-2">
                    Description
                </h1>

                {{ $character->description }}
            </div>
        </div>
    </div>
</x-app-layout>
