<div {{ $attributes->merge(['class' => 'bg-gray-100 dark:bg-gray-700 rounded-full']) }}>
    <form method="GET" action="{{ $route }}">
        @csrf
        <div class="flex items-center relative">
            <input class="px-3 w-full bg-transparent border-0 rounded-full focus:ring-blue-200 dark:focus:ring-blue-500 dark:text-gray-200"
                   type="text"
                   name="search"
                   placeholder="{{ __('ui.search') }}"
                   value="{{ isset($search) ? $search : "" }}"
            />

            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 h-6 w-6 text-gray-400 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </form>
</div>
