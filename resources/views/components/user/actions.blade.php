@can('update', $user)
    <x-action-button text="{{ __('users.edit') }}"
                     method="GET"
                     action="{{ route('users.edit', $user) }}"
                     color="bg-gray-100 dark:bg-gray-700"
                     colorHover="border-gray-200 dark:border-gray-600"
                     colorRing="ring-gray-300 dark:ring-gray-500"
                     icon="fa fa-edit"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('accounts', $user)
    <x-action-button text="{{ __('accounts.index') }}"
                     method="GET"
                     action="{{ route('users.accounts.index', $user) }}"
                     color="bg-gray-100 dark:bg-gray-700"
                     colorHover="border-gray-200 dark:border-gray-600"
                     colorRing="ring-gray-300 dark:ring-gray-500"
                     icon="fa fa-users"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('ban', $user)
    <x-action-button text="{{ __('users.ban') }}"
                     method="GET"
                     action="{{ route('users.ban.create', $user) }}"
                     color="bg-red-100 dark:bg-red-500"
                     colorHover="border-red-200"
                     colorRing="ring-red-300"
                     icon="fa fa-gavel"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@if ($user->isBanned)
    @can('unban', $user)
        <x-action-button text="{{ __('users.unban') }}"
                         bladeMethod="DELETE"
                         action="{{ route('users.ban.destroy', ['user' => $user, 'ban' => 'qwe']) }}"
                         color="bg-green-100 dark:bg-green-700"
                         colorHover="border-green-200 dark:border-green-600"
                         colorRing="ring-green-300 dark:ring-green-500"
                         icon="fa fa-check"
                         tooltip="{{ isset($tooltip) }}"
        />
    @endcan
@endif

@can('delete', $user)
    <x-action-button text="{{ __('users.delete') }}"
                     action="{{ route('users.destroy', $user) }}"
                     bladeMethod="DELETE"
                     color="bg-red-300 dark:bg-red-500"
                     colorHover="border-red-400"
                     colorRing="ring-red-500"
                     confirmationText="return confirm('{{ __('ui.confirm') }}')"
                     icon="fa fa-trash"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan
