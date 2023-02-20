<a
    @can('view', $user)
        class="font-bold underline text-blue-600 visited:text-purple-600"
        href="{{ route('users.show', $user) }}"
    @endcan
    title="{{ $user->discord_tag }}"
>
    {{ $user->login }}
</a>
