<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-gray-900 focus:outline-none focus:border-blue-600 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
