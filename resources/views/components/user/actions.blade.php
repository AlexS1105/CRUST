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
