<h2 class="mt-2" id="{{ $id }}-open-heading-{{$loop->iteration}}">
    <button type="button"
            class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 dark:text-gray-200 border border-gray-200 dark:border-gray-400 hover:bg-gray-100 dark:hover:bg-gray-500 rounded-xl"
            data-accordion-target="#{{ $id }}-open-body-{{$loop->iteration}}"
            aria-expanded="false"
            aria-controls="{{ $id }}-open-body-{{$loop->iteration}}">
        <span>{{ $title }}</span>
        <svg data-accordion-icon class="w-6 h-6 shrink-0"
             fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
        </svg>
    </button>
</h2>
<div id="{{ $id }}-open-body-{{$loop->iteration}}" class="hidden overflow-hidden border border-t-0 border-gray-200 dark:border-gray-400 rounded-b-xl" aria-labelledby="{{ $id }}-open-heading-{{$loop->iteration}}">
    @if(!empty($body))
        {{ $body }}
    @endif

    @if(!empty($content))
        <div class="p-2 font-light">
            <p class="mb-2 text-gray-500 dark:text-gray-300">{{ $content }}</p>
        </div>
    @endif

    @if(!empty($buttons))
        <div class="inline-flex flex-wrap" role="group">
            {{ $buttons }}
        </div>
    @endif

    {{ $slot ?? null }}
</div>
