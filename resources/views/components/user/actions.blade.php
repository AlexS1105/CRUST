@can('update', $user)
    <x-action-button text="Edit"
        method="GET"
        action="{{ route('users.edit', $user) }}"
        color="gray-100"
        colorHover="gray-200"
        colorRing="gray-300"
        icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
        tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('ban', $user)
    <x-action-button text="Ban"
        method="GET"
        action="{{ route('users.ban.create', $user) }}"
        color="red-100"
        colorHover="red-200"
        colorRing="red-300"
        icon="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
        tooltip="{{ isset($tooltip) }}"
    />
@endcan

@if ($user->ban)
    @can('unban', $user)
    <x-action-button text="Unban"
        bladeMethod="DELETE"
        action="{{ route('ban.destroy', $user->ban) }}"
        color="green-100"
        colorHover="green-200"
        colorRing="green-300"
        icon="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"
        tooltip="{{ isset($tooltip) }}"
    />
    @endcan
@endif

@can('delete', $user)
    <x-action-button text="Delete"
        action="{{ route('users.destroy', $user) }}"
        bladeMethod="DELETE"
        color="red-300"
        colorHover="red-400"
        colorRing="red-500"
        confirmationText="return confirm('{{ __('Are you sure?') }}')"
        icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
        tooltip="{{ isset($tooltip) }}"
    />
@endcan
