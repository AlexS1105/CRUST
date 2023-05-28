<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="table-auto w-full border">
        <thead class="border bg-gray-200 dark:bg-gray-800 dark:text-gray-300 text-center">
            {{ $heading }}
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
