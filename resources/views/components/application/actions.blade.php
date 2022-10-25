@can('force-delete', $character)
    <x-action-button text="{{ __('applications.force_delete') }}"
                     action="{{ route('characters.force_destroy', $character->login) }}"
                     bladeMethod="DELETE"
                     color="bg-red-300"
                     colorHover="border-red-400"
                     colorRing="ring-red-500"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.force_delete')]) }}')"
                     icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('restore', $character)
    <x-action-button text="{{ __('applications.restore') }}"
                     action="{{ route('characters.restore', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-100"
                     colorHover="border-blue-200"
                     colorRing="ring-blue-300"
                     icon="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z6"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('delete', $character)
    <x-action-button text="{{ __('applications.delete') }}"
                     action="{{ route('characters.destroy', $character->login) }}"
                     bladeMethod="DELETE"
                     color="bg-red-300"
                     colorHover="border-red-400"
                     colorRing="ring-red-500"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.delete')]) }}')"
                     icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('update', $character)
    <x-action-button text="{{ __('applications.edit') }}"
                     method="GET"
                     action="{{ route('characters.edit', $character->login) }}"
                     color="bg-gray-100"
                     colorHover="border-gray-200"
                     colorRing="ring-gray-300"
                     icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('send', $character)
    <x-action-button text="{{ __('applications.send') }}"
                     action="{{ route('applications.send', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-100"
                     colorHover="border-blue-200"
                     colorRing="ring-blue-300"
                     icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('cancel', $character)
    <x-action-button text="{{ __('applications.cancel') }}"
                     action="{{ route('applications.cancel', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-gray-200"
                     colorHover="border-gray-300"
                     colorRing="ring-gray-400"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.cancel')]) }}')"
                     icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('take-for-approval', $character)
    <x-action-button text="{{ __('applications.take') }}"
                     action="{{ route('applications.take_for_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-blue-200"
                     colorHover="border-blue-300"
                     colorRing="ring-blue-400"
                     icon="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('cancel-approval', $character)
    <x-action-button text="{{ __('applications.cancel_approval') }}"
                     action="{{ route('applications.cancel_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-red-200"
                     colorHover="border-red-300"
                     colorRing="ring-red-400"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.cancel_approval')]) }}')"
                     icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('request-changes', $character)
    <x-action-button text="{{ __('applications.request_changes') }}"
                     action="{{ route('applications.request_changes', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-yellow-200"
                     colorHover="border-yellow-300"
                     colorRing="ring-yellow-400"
                     icon="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('request-approval', $character)
    <x-action-button text="{{ __('applications.request_approval') }}"
                     action="{{ route('applications.request_approval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-green-100"
                     colorHover="border-green-200"
                     colorRing="ring-green-300"
                     icon="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('approve', $character)
    <x-action-button text="{{ __('applications.approve') }}"
                     action="{{ route('applications.approve', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-green-200"
                     colorHover="border-green-300"
                     colorRing="ring-green-400"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.approval')]) }}')"
                     icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan

@can('reapproval', $character)
    <x-action-button text="{{ __('applications.reapproval') }}"
                     action="{{ route('applications.reapproval', $character->login) }}"
                     bladeMethod="PATCH"
                     color="bg-yellow-100"
                     colorHover="border-yellow-200"
                     colorRing="ring-yellow-300"
                     confirmationText="return confirm('{{ __('ui.confirm', ['tip' => __('tips.character.reapproval')]) }}')"
                     icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                     tooltip="{{ isset($tooltip) }}"
    />
@endcan
