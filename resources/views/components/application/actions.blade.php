@if ($character->status == \App\Enums\CharacterStatus::Deleting())
  @can('forceDelete', $character)
    <x-action-button text="Force Delete"
      action="{{ route('characters.forceDestroy', $character->login) }}"
      bladeMethod="DELETE"
      color="red-300"
      colorHover="red-400"
      colorRing="red-500"
      confirmationText="return confirm('{{ __('Are you sure?') }}')"
      icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
      tooltip="{{ isset($tooltip) }}"
    />
  @endcan

  @can('restore', $character)
    <x-action-button text="Restore"
      action="{{ route('characters.restore', $character->login) }}"
      bladeMethod="PATCH"
      color="blue-100"
      colorHover="blue-200"
      colorRing="blue-300"
      icon="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z6"
      tooltip="{{ isset($tooltip) }}"
    />
  @endcan
@else
  @can('delete', $character)
    <x-action-button text="Delete"
      action="{{ route('characters.destroy', $character->login) }}"
      bladeMethod="DELETE"
      color="red-100"
      colorHover="red-200"
      colorRing="red-300"
      confirmationText="return confirm('{{ __('Are you sure?') }}')"
      icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
      tooltip="{{ isset($tooltip) }}"
    />
	@endcan

	@can('edit', $character)
    <x-action-button text="Edit"
      method="GET"
      action="{{ route('characters.edit', $character->login) }}"
      color="gray-100"
      colorHover="gray-200"
      colorRing="gray-300"
      icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
      tooltip="{{ isset($tooltip) }}"
    />
	@endcan

	@if ($character->status == \App\Enums\CharacterStatus::Blank())
		@can('send', $character)
			<x-action-button text="Send To Approval"
				action="{{ route('applications.send', $character->login) }}"
				bladeMethod="PATCH"
				color="blue-100"
				colorHover="blue-200"
				colorRing="blue-300"
				icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
				tooltip="{{ isset($tooltip) }}"
			/>
		@endcan
	@endif

	@if ($character->status == \App\Enums\CharacterStatus::Pending())
		@can('cancel', $character)
			<x-action-button text="Cancel"
				action="{{ route('applications.cancel', $character->login) }}"
				bladeMethod="PATCH"
				color="gray-200"
				colorHover="gray-300"
				colorRing="gray-400"
				confirmationText="return confirm('{{ __('Are you sure?') }}')"
				icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
				tooltip="{{ isset($tooltip) }}"
			/>
		@endcan
		@can('takeForApproval', $character)
			<x-action-button text="Take For Approval"
				action="{{ route('applications.takeForApproval', $character->login) }}"
				bladeMethod="PATCH"
				color="blue-200"
				colorHover="blue-300"
				colorRing="blue-400"
				icon="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"
				tooltip="{{ isset($tooltip) }}"
			/>
		@endcan
	@endif

	@if ($character->status == \App\Enums\CharacterStatus::Approval())
		@can('cancelApproval', $character)
			<x-action-button text="Cancel Approval"
				action="{{ route('applications.cancelApproval', $character->login) }}"
				bladeMethod="PATCH"
				color="yellow-200"
				colorHover="yellow-300"
				colorRing="yellow-400"
				confirmationText="return confirm('{{ __('Are you sure?') }}')"
				icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
				tooltip="{{ isset($tooltip) }}"
			/>
		@endcan
		@can('approve', $character)
			<x-action-button text="Approve"
				action="{{ route('applications.approve', $character->login) }}"
				bladeMethod="PATCH"
				color="green-200"
				colorHover="green-300"
				colorRing="green-400"
				icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
				tooltip="{{ isset($tooltip) }}"
			/>    
		@endcan
	@endif

	@if ($character->status == \App\Enums\CharacterStatus::Approved())
		@can('reapproval', $character)
			<x-action-button text="Send For Reapproval"
				action="{{ route('applications.reapproval', $character->login) }}"
				bladeMethod="PATCH"
				color="yellow-100"
				colorHover="yellow-200"
				colorRing="yellow-300"
				confirmationText="return confirm('{{ __('Are you sure?') }}')"
				icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
				tooltip="{{ isset($tooltip) }}"
			/>
		@endcan
	@endif
@endif
