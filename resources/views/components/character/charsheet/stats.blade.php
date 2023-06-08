<div class="lg:flex lg:space-y-0 space-y-4 gap-4 dark:text-gray-100">
    <table class="table w-full p-1">
        <thead>
            <tr>
                <th colspan="2" class="border border-red-300 dark:border-red-600 bg-red-200 dark:bg-red-500 p-2 text-center text-xl">
                    <div class="dark:drop-shadow-xs">
                        {{ __('stat.body') }}
                        {{ $headerBody }}
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach (App\Enums\CharacterStat::getBodyStats() as $stat)
            <tr class="border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-500 bg-{{ $stat->color() }}-100 dark:bg-{{ $stat->color() }}-400">
                <td class="p-2 text-lg">
                    <div class="dark:drop-shadow-xs">
                        {{ __('stat.' . $stat->value) }}
                    </div>
                </td>
                <td class="p-2 text-xl text-center font-bold border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-500">
                    <div class="dark:drop-shadow-xs">
                        {{ ${$stat->value} }}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class="table w-full">
        <thead>
        <tr>
            <th colspan="2" class="border border-cyan-300 dark:border-cyan-600 bg-cyan-200 dark:bg-cyan-500 p-2 text-center text-xl">
                <div class="dark:drop-shadow-xs">
                    {{ __('stat.essence') }}
                    {{ $headerEssence }}
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach (App\Enums\CharacterStat::getEssenceStats() as $stat)
            <tr class="border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-500 bg-{{ $stat->color() }}-100 dark:bg-{{ $stat->color() }}-400">
                <td class="p-2 text-lg">
                    <div class="dark:drop-shadow-xs">
                        {{ __('stat.' . $stat->value) }}
                    </div>
                </td>
                <td class="p-2 text-xl text-center font-bold border border-t-0 border-{{ $stat->color() }}-200 dark:border-{{ $stat->color() }}-500">
                    <div class="dark:drop-shadow-xs">
                        {{ ${$stat->value} }}
                    <div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
