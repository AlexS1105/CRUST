<div class="lg:flex lg:space-y-0 space-y-4 gap-4 dark:text-gray-100">
    <table class="table w-full p-1">
        <thead>
            <tr>
                <th colspan="2" class="border border-red-300 dark:border-red-500 bg-red-200 dark:bg-red-500 p-2 text-center text-xl">
                    {{ __('stat.body') }}
                    {{ $headerBody }}
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach (App\Enums\CharacterStat::getBodyStats() as $stat)
            <tr class="border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-400 bg-{{ $stat->color() }}-100 dark:bg-{{ $stat->color() }}-400">
                <td class="p-2 text-lg">{{ __('stat.' . $stat->value) }}</td>
                <td class="p-2 text-xl text-center font-bold border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-400">{{ ${$stat->value} }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class="table w-full">
        <thead>
        <tr>
            <th colspan="2" class="border border-cyan-300 dark:border-cyan-500 bg-cyan-200 dark:bg-cyan-500 p-2 text-center text-xl">
                {{ __('stat.essence') }}
                {{ $headerEssence }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach (App\Enums\CharacterStat::getEssenceStats() as $stat)
            <tr class="border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-400 bg-{{ $stat->color() }}-100 dark:bg-{{ $stat->color() }}-400">
                <td class="p-2 text-lg">{{ __('stat.' . $stat->value) }}</td>
                <td class="p-2 text-xl text-center font-bold border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-400">{{ ${$stat->value} }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
