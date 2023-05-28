<div {{ $attributes->merge(['class' => 'text-sm text-gray-500 dark:text-gray-300']) }}>
    {{ isset($text) ? __('tips.' . $text) : $slot }}
</div>
