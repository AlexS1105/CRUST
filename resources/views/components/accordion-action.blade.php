<form method="{{ $method == 'GET' ? $method : 'POST' }}" action="{{ $action }}">
    @if($method != 'GET')
        @method($method)
        @csrf
    @endif
    <button type="submit"
            {{ $attributes->class('inline-flex items-center py-2 px-4 gap-2 font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border-b border-l border-r border-gray-200 dark:border-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600') }}
            {{ $confirm ?? false ? 'onclick="if (!confirm(' . __('ui.confirm', ['tip' => '']) . ')) { event.preventDefault();}"' : '' }}
    >
        <div class="fa {{ $icon }} text-lg text-gray-600 dark:text-gray-300"></div>
        {{ $slot }}
    </button>
</form>
