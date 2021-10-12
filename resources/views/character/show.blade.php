<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-2xl text-gray-600">
            <div>
                <h2 class="font-semibold leading-tight text-gray-800">
                    {{ $character->name }}
                </h2>
                <div class="font-thin text-base">
                    Login: {{ $character->login }}
                </div>
            </div>
            <div>
                <div class="flex items-center gap-4 font-bold">
                    Status: <x-character-status :status="$character->status"/>
                </div>
                <div class="font-thin text-base text-right">
                    Registrar: {{ $character->registrar->name }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto space-y-8">
        <div class="bg-white p-4 rounded-xl place-self-center max-w-md mx-auto shadow-lg">
            <img
                class="object-cover"
                src="{{ $character->getReference(); }}"
                alt="Character Reference"
            >
        </div>

        <div class="bg-white p-4 rounded-xl shadow-lg">
            <h1 class="font-bold text-xl mb-2">
                Description
            </h1>

            {{ $character->description }}
        </div>
    </div>
</x-app-layout>
