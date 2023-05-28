@props([
    'self' => false,
    'rumor',
])

<div class="px-3 py-2 rounded-xl bg-{{ $rumor->tide->color() }}-100 {{ $rumor->user->is(auth()->user()) ? 'border border-2 border-'.$rumor->tide->color().'-300' : '' }}">
    <div class="flex justify-between gap-4">
        <div class="text-lg">
            {{ $rumor->text }}
        </div>
        <div class="flex gap-2 right-0">
            @can('manage', $rumor)
                <a class="fas fa-edit text-xl text-gray-600"
                   href="{{ route('rumors.edit', $rumor) }}"></a>

                <form method="POST" action="{{ route('rumors.destroy', $rumor) }}">
                    @method('DELETE')
                    @csrf

                    <a class="fas fa-trash cursor-pointer text-xl text-gray-600"
                       onclick="if (confirm('{{ __('ui.confirm', ['tip' => '']) }}')) {
                                    event.preventDefault();
                                    this.closest('form').submit();
                                  }"></a>
                </form>
            @endcan
        </div>
    </div>
    <div class="mt-2 inline-flex gap-2 items-center">
        @if($self)
            @can('view', $rumor->character)
                <x-link href="{{ route('characters.show', $rumor->character->login) }}">
                    {{ $rumor->character->name }}
                </x-link>
            @else
                ???
            @endcan
        @endif

        @can('see-user', $rumor)
            <div class="text-sm text-gray-500">
                {{ __('rumors.from') }}
            </div>
            <div class="text-sm text-gray-500">
                <x-user-link :user="$rumor->user"/>
            </div>
        @endcan

        <div class="text-right text-xs text-gray-500" title="{{ $rumor->created_at }}">
            {{ $rumor->created_at->diffForHumans() }}
        </div>
    </div>
</div>
