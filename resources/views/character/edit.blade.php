<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Character') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6">
        <form method="POST" action="{{ route('characters.update', $character->login) }}">
            @csrf
            @method('PATCH')

            <x-form.input name="name" required />
            <x-form.textarea name="description" required />

            <x-button>
                Submit
            </x-button>
        </form>
    </div>
</x-app-layout>
