<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users.ban') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST" action="{{ route('users.ban.store', $user) }}">
            @csrf

            <x-form.card>
                <x-form.input name="expires" type="datetime-local" list="durations"
                              min="{{ now()->format('Y-m-d\TH:i') }}"/>
                <datalist id="durations">
                    @php
                        $periods = [
                          now()->addHours(6),
                          now()->addHours(12),
                          now()->addDay(),
                          now()->addDays(2),
                          now()->addDays(3),
                          now()->addWeek(),
                          now()->addWeeks(2),
                          now()->addMonth(),
                          now()->addMonths(2),
                          now()->addMonths(3),
                          now()->addMonths(6),
                          now()->addYear()
                        ];
                    @endphp

                    @foreach ($periods as $time)
                        <option
                            label="{{ Carbon\Carbon::parse($time)->addMinute()->diffForHumans() }}">{{ $time->format('Y-m-d\TH:i') }}</option>
                    @endforeach
                </datalist>
                <x-form.input name="reason" required maxlength="256"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
