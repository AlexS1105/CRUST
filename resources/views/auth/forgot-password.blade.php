<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/">
				<x-application-logo class="w-80 h-80 fill-current text-gray-500" />
			</a>
		</x-slot>

		<div class="mb-4 text-sm text-gray-600">
			{{ __('forgot_password.message') }}
		</div>

		<!-- Session Status -->
		<x-auth-session-status class="mb-4" :status="session('status')" />

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		@if (isset($error))
			<p class="text-red-500 text-xs mb-4">{{ $error }}</p>
		@endif

		<div class="text-center">
			<x-button class="bg-indigo-500 w-full place-content-center" onclick="window.location.href='{{ config('services.discord.oauth2url.reset') }}'" type="button">
				<div class="fab fa-discord mx-2"></div>
				{{ __('forgot_password.button') }}
			</x-button>
		</div>
	</x-auth-card>
</x-guest-layout>
