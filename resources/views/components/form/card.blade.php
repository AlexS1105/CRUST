<x-card class="p-6">
    @if (isset($header))
        <h1 class="text-xl font-bold text-gray-700 dark:text-gray-200 uppercase mb-4">
            {{ $header }}
        </h1>
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>
</x-card>
