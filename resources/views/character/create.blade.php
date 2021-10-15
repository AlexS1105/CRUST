<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Character') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6">
        <form method="POST" action="{{ route('characters.store') }}" enctype="multipart/form-data">
            @csrf

            <x-form.input name="name" required />
            <x-form.input name="login" required maxlength="16" />
            <x-form.input name="reference" type="file" accept="image/*" />
            <x-form.textarea name="description" required />

            <x-button>
                Submit
            </x-button>
        </form>

        <script src="{{ asset('js/character.js') }}"></script>
    </div>
</x-app-layout>
