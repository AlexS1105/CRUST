<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Character') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto space-y-8">
        <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6">
            <form method="POST" action="{{ route('characters.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="name"
                    >
                        Name
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Name"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="login"
                    >
                        Login
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                        type="text"
                        name="login"
                        id="login"
                        placeholder="Login"
                        value="{{ old('login') }}"
                        required
                    >
                
                    @error('login')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="description"
                    >
                        Description
                    </label>

                    <textarea class="border border-gray-400 p-2 w-full"
                        type="text"
                        name="description"
                        id="description"
                        placeholder="Description"
                        required
                    >{{ old('description') }}</textarea>
                
                    @error('description')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <x-button>
                    Submit
                </x-button>
            </form>

            <script src="{{ asset('js/character.js') }}"></script>
        </div>
    </div>
</x-app-layout>
