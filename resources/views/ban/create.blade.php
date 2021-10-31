<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Ban User') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <form class="space-y-8" method="POST" action="{{ route('users.ban.store', $user) }}">
      @csrf

      <x-form.card>
        <x-form.input name="expires" type="datetime-local" list="durations" min="{{ now()->format('Y-m-d\TH:i') }}" required />
        <datalist id="durations">
          <option label="6 hours">{{ now()->addHours(6)->format('Y-m-d\TH:i') }}</option>
          <option label="12 hours">{{ now()->addHours(12)->format('Y-m-d\TH:i') }}</option>
          <option label="Day">{{ now()->addDay()->format('Y-m-d\TH:i') }}</option>
          <option label="2 days">{{ now()->addDays(2)->format('Y-m-d\TH:i') }}</option>
          <option label="3 days">{{ now()->addDays(3)->format('Y-m-d\TH:i') }}</option>
          <option label="Week">{{ now()->addWeek()->format('Y-m-d\TH:i') }}</option>
          <option label="2 weeks">{{ now()->addWeeks(2)->format('Y-m-d\TH:i') }}</option>
          <option label="Month">{{ now()->addMonth()->format('Y-m-d\TH:i') }}</option>
          <option label="2 months">{{ now()->addMonths(2)->format('Y-m-d\TH:i') }}</option>
          <option label="6 months">{{ now()->addMonths(6)->format('Y-m-d\TH:i') }}</option>
          <option label="Year">{{ now()->addYear()->format('Y-m-d\TH:i') }}</option>
        </datalist>
        <x-form.input name="reason" required maxlength="256" />

        <x-button>
          Submit
        </x-button>
      </x-form.card>
    </form>
  </x-container>
</x-app-layout>
