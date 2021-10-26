<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/">
				<x-application-logo class="w-20 h-20 fill-current text-gray-500" />
			</a>
		</x-slot>

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form class='space-y-4' method="POST" action="{{ route('register') }}">
			@csrf

			<x-form.input name="name" value="{{ old('name', $discord_data['username']) }}" required autofocus />
			<x-form.input name="discord_tag" value="{{ old('discord_tag', $discord_data['username'].'#'.$discord_data['discriminator']) }}" pattern="^.{3,32}#[0-9]{4}$" required readonly />
			<x-form.input name="discord_id" value="{{ old('discord_id', $discord_data['id']) }}" required readonly />
			<x-form.input name="email" required />
			<x-form.input name="password" type="password" autocomplete="new-password" required />
			<x-form.input name="password_confirmation" type="password" required />

			<x-form.checkbox name="age_confirmation" required />
			<x-form.checkbox name="rules_confirmation" required />

			<div class="flex items-center justify-end mt-4">
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
					{{ __('register.already') }}
				</a>

				<x-button class="ml-4">
					{{ __('register.register') }}
				</x-button>
			</div>
		</form>
	</x-auth-card>
</x-guest-layout>
