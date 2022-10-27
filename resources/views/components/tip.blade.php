<div {{ $attributes->merge(['class' => 'text-sm text-gray-500']) }}>
    {{ isset($text) ? __('tips.' . $text) : $slot }}
</div>
