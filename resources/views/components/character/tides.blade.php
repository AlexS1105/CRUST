<div class="space-y-2">
    @foreach (App\Enums\Tide::cases() as $tide)
        <div class="bg-{{ $tide->color() }}-200 dark:bg-{{ $tide->color() }}-400 rounded-xl py-1 px-2">
            <div class="text-xl font-bold gap-4 flex justify-between items-center ">
                <div class="bg-{{ $tide->color() }}-300 dark:bg-{{ $tide->color() }}-500 rounded-xl px-2 dark:text-gray-100">
                    <div class="dark:drop-shadow-xs">
                        {{ $tide->localized() }}
                    </div>
                </div>

                <div class="w-8 h-8 inline-flex text-center items-center justify-center bg-{{ $tide->color() }}-300 dark:bg-{{ $tide->color() }}-500 p-1 rounded-xl">
                    <div class="dark:drop-shadow-xs">
                        {{ ${'level_' . $tide->value} ?? '' }}
                    </div>
                </div>
            </div>

            @if(!empty(${'content_' . $tide->value}))
                <div class="p-2 text-xl">
                    <div class="dark:drop-shadow-xs">
                        {{ ${'content_' . $tide->value} }}
                    </div>
                </div>
            @endif
        </div>
    @endforeach

    {{ $slot }}
</div>
