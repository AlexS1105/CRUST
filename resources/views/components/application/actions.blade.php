@can('force-delete', $character)
    <x-action-button text="{{ __('applications.force_delete') }}"
                     action="{{ route('characters.force_destroy', $character->login) }}"
                     bladeMethod="DELETE"
                     color="bg-red-300 dark:bg-red-500"
                     colorHover="border-red-400 dark:border-red-600"
                     colorRing="ring-red-500 dark:ring-red-700"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.force_delete')]) }}')"
                     icon="fa-solid fa-trash"
                     :icons="$icons"
    />
@endcan

@can('restore', $character)
    <x-action-button text="{{ __('applications.restore') }}"
                     action="{{ route('characters.restore', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-100 dark:bg-blue-300"
                     colorHover="border-blue-200 dark:border-blue-300"
                     colorRing="ring-blue-300 dark:ring-blue-400"
                     icon="fa-solid fa-trash-can-arrow-up"
                     :icons="$icons"
    />
@endcan

@can('delete', $character)
    <x-action-button text="{{ __('applications.delete') }}"
                     action="{{ route('characters.destroy', $character->login) }}"
                     bladeMethod="DELETE"
                     color="bg-red-300 dark:bg-red-500"
                     colorHover="border-red-400 dark:border-red-600"
                     colorRing="ring-red-500 dark:ring-red-700"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.delete')]) }}')"
                     icon="fa-solid fa-trash"
                     :icons="$icons"
    />
@endcan

@can('update', $character)
    <x-action-button text="{{ __('applications.edit') }}"
                     method="GET"
                     action="{{ route('characters.edit', $character->login) }}"
                     color="bg-gray-100 dark:bg-gray-400"
                     colorHover="border-gray-200 dark:border-gray-500"
                     colorRing="ring-gray-300 dark:ring-gray-600"
                     icon="fa-solid fa-user-pen"
                     :icons="$icons"
    />
@endcan

@can('send', $character)
    <x-action-button text="{{ __('applications.send') }}"
                     action="{{ route('applications.send', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-100 dark:bg-blue-300"
                     colorHover="border-blue-200 dark:border-blue-400"
                     colorRing="ring-blue-300 dark:ring-blue-500"
                     icon="fa-solid fa-paper-plane"
                     :icons="$icons"
    />
@endcan

@can('cancel', $character)
    <x-action-button text="{{ __('applications.cancel') }}"
                     action="{{ route('applications.cancel', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-gray-200 dark:bg-gray-400"
                     colorHover="border-gray-300 dark:border-gray-500"
                     colorRing="ring-gray-400 dark:ring-gray-600"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.cancel')]) }}')"
                     icon="fa-solid fa-arrow-left"
                     :icons="$icons"
    />
@endcan

@can('take-for-approval', $character)
    <x-action-button text="{{ __('applications.take') }}"
                     action="{{ route('applications.take_for_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-200 dark:bg-blue-400"
                     colorHover="border-blue-300 dark:border-blue-500"
                     colorRing="ring-blue-400 dark:ring-blue-600"
                     icon="fa-solid fa-magnifying-glass-arrow-right"
                     :icons="$icons"
    />
@endcan

@can('cancel-approval', $character)
    <x-action-button text="{{ __('applications.cancel_approval') }}"
                     action="{{ route('applications.cancel_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-red-200 dark:bg-red-300"
                     colorHover="border-red-300 dark:border-red-400"
                     colorRing="ring-red-400 dark:ring-red-500"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.cancel_approval')]) }}')"
                     icon="fa-solid fa-user-xmark"
                     :icons="$icons"
    />
@endcan

@can('request-changes', $character)
    <x-action-button text="{{ __('applications.request_changes') }}"
                     action="{{ route('applications.request_changes', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-yellow-200 dark:bg-yellow-400"
                     colorHover="border-yellow-300 dark:border-yellow-500"
                     colorRing="ring-yellow-400 dark:ring-yellow-600"
                     icon="fa-solid fa-pen-ruler"
                     :icons="$icons"
    />
@endcan

@can('request-approval', $character)
    <x-action-button text="{{ __('applications.request_approval') }}"
                     action="{{ route('applications.request_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-green-100 dark:bg-green-300"
                     colorHover="border-green-200 dark:border-green-400"
                     colorRing="ring-green-300 dark:ring-green-500"
                     icon="fa-solid fa-circle-check"
                     :icons="$icons"
    />
@endcan

@can('approve', $character)
    <x-action-button text="{{ __('applications.approve') }}"
                     action="{{ route('applications.approve', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-green-200 dark:bg-green-400"
                     colorHover="border-green-300 dark:border-green-500"
                     colorRing="ring-green-400 dark:ring-green-600"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.approval')]) }}')"
                     icon="fa-solid fa-check"
                     :icons="$icons"
    />
@endcan

@can('reapproval', $character)
    <x-action-button text="{{ __('applications.reapproval') }}"
                     action="{{ route('applications.reapproval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-yellow-100 dark:bg-yellow-300"
                     colorHover="border-yellow-200 dark:border-yellow-400"
                     colorRing="ring-yellow-300 dark:ring-yellow-500"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.reapproval')]) }}')"
                     icon="fa-solid fa-arrows-rotate"
                     :icons="$icons"
    />
@endcan
