<div class="flex w-full justify-center">
    <a {{ $attributes->merge(['class' => 'text-lg bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-300 py-2 px-3 rounded-full font-bold shadow align-self-center hover:bg-blue-100 focus:ring-2']) }}>
        {{ $slot }}
    </a>
</div>
