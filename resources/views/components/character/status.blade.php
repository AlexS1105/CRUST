<div
    class="px-2 text-white {{ $status->bgColor() }} ring-4 {{ $status->ringColor() }} ring-opacity-50 rounded-full font-bold whitespace-nowrap text-sm">
    <div class="dark:drop-shadow-xs">
        {{ $status->localized() }}
    </div>
</div>
