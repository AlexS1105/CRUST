<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/">
				<x-application-logo class="w-20 h-20 fill-current text-gray-500" />
			</a>
		</x-slot>

		<!-- Validation Errors -->
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form method="POST" action="{{ route('register') }}">
			@csrf

			<div>
				<x-label for="discord_tag" :value="__('Discord Tag')" />

				<x-input id="discord_tag" class="block mt-1 w-full bg-gray-100 opacity-75" type="text" name="discord_tag" :value="old('discord_tag', $discord_data['username'].'#'.$discord_data['discriminator'])" pattern="^.{3,32}#[0-9]{4}$" required readonly />
			</div>

			<div class="mt-4">
				<x-label for="discord_id" :value="__('Discord Id')" />

				<x-input id="discord_id" class="block mt-1 w-full bg-gray-100 opacity-75" type="text" name="discord_id" :value="old('discord_id', $discord_data['id'])" readonly required />
			</div>

			<!-- Name -->
			<div class="mt-4">
				<x-label for="name" :value="__('Name')" />

				<x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $discord_data['username'])" required autofocus />
			</div>

			<!-- Email Address -->
			<div class="mt-4">
				<x-label for="email" :value="__('Email')" />

				<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
			</div>

			<!-- Password -->
			<div class="mt-4">
				<x-label for="password" :value="__('Password')" />

				<x-input id="password" class="block mt-1 w-full"
								type="password"
								name="password"
								required autocomplete="new-password" />
			</div>

			<!-- Confirm Password -->
			<div class="mt-4">
				<x-label for="password_confirmation" :value="__('Confirm Password')" />

				<x-input id="password_confirmation" class="block mt-1 w-full"
								type="password"
								name="password_confirmation" required />
			</div>

			<div class="mt-4 flex items-center space-x-2">
				<x-input id="age_confirmation" class="block"
								type="checkbox"
								name="age_confirmation" required />

				<x-label for="age_confirmation" :value="__('I am 18 years old and I am an adult')" />
			</div>

			<div class="mt-4 flex items-start space-x-2">
				<x-input id="rules_confirmation" class="block"
								type="checkbox"
								name="rules_confirmation" required />

				<x-label for="rules_confirmation" :value="__('I have read the project rules, I fully agree with them and undertake to abide by them, and also unconditionally acknowledge the project administration\'s right to interpret them.')" />
			</div>

			<div class="flex items-center justify-end mt-4">
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
					{{ __('Already registered?') }}
				</a>

				<x-button class="ml-4">
					{{ __('Register') }}
				</x-button>
			</div>
		</form>
	</x-auth-card>
</x-guest-layout>
