<div class="text-lg font-semibold text-right">
    {{ $slot }}
</div>
<div class="w-full bg-gray-200 rounded-full my-auto p-0.5">
    <div class="bg-blue-400 rounded-full h-3" style="width: {{ $value * 10 }}%">
        <div
            class="text-sm font-medium text-white text-center leading-none {{ $value == 0 ? "hidden" : "" }}">
            {{ $value }}
        </div>
    </div>
</div>
