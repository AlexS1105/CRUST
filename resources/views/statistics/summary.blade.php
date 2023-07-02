@extends('layouts.app')

@section('header', __('statistics.summary'))

@section('content')
    <x-container>
        <x-card class="mx-auto shadow-lg place-self-start p-6 dark:text-gray-200">
            <div class="text-xs mb-4">Учитываются нетехнические персонажи кроме статусов "Черновик" и "Удалён"</div>

            <x-header>{{ __('characters.all') }}</x-header>
            <x-markdown class="max-w-none">
                Всего в выборке **{{ $summary['characters_count'] ?? 0 }}** персонажей, из них:
- **{{ $summary['characters_approved'] ?? 0 }}** проверенных ({{ $summary['characters_approved_percentage'] ?? 0 }}%)
- **{{ $summary['characters_process'] ?? 0 }}** ещё находятся на одной из стадий проверки ({{ $summary['characters_process_percentage'] ?? 0 }}%)
            </x-markdown>

            <x-header>{{ __('label.origin') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Происхождение
                    </x-table.header>
                    <x-table.header>
                        Количество
                    </x-table.header>
                    <x-table.header>
                        %
                    </x-table.header>
                </x-slot>
                @foreach($summary['origins'] as $name => $count)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $count ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $summary['origins_percentage'][$name] ?? '-' }}%
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>

            <x-header>{{ __('label.estitence') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Показатель
                    </x-table.header>
                    <x-table.header>
                        Значение
                    </x-table.header>
                    <x-table.header>
                        Персонажи
                    </x-table.header>
                </x-slot>
                <x-table.row>
                    <x-table.cell>
                        Сумма
                    </x-table.cell>
                    <x-table.cell>
                        {{ $summary['estitence_sum'] ?? '-' }}
                    </x-table.cell>
                    <x-table.cell>
                        -
                    </x-table.cell>
                </x-table.row>
                <x-table.row>
                    <x-table.cell>
                        Среднее
                    </x-table.cell>
                    <x-table.cell>
                        {{ $summary['estitence_avg'] ?? '-' }}
                    </x-table.cell>
                    <x-table.cell>
                        -
                    </x-table.cell>
                </x-table.row>
                <x-table.row>
                    <x-table.cell>
                        Минимум
                    </x-table.cell>
                    <x-table.cell>
                        {{ $summary['estitence_min'] ?? '-' }}
                    </x-table.cell>
                    <x-table.cell>
                        @foreach($summary['estitence_min_characters'] as $character)
                            <x-link href="{{ route('characters.show', $character) }}">
                                {{ $character->name }}
                            </x-link>
                        @endforeach
                    </x-table.cell>
                </x-table.row>
                <x-table.row>
                    <x-table.cell>
                        Максимум
                    </x-table.cell>
                    <x-table.cell>
                        {{ $summary['estitence_max'] ?? '-' }}
                    </x-table.cell>
                    <x-table.cell>
                        @foreach($summary['estitence_max_characters'] as $character)
                            <x-link href="{{ route('characters.show', $character) }}">
                                {{ $character->name }}
                            </x-link>
                        @endforeach
                    </x-table.cell>
                </x-table.row>
            </x-table>

            <x-header>{{ __('charsheet.stats') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Характеристика
                    </x-table.header>
                    <x-table.header>
                        Сумма
                    </x-table.header>
                    <x-table.header>
                        Среднее
                    </x-table.header>
                </x-slot>

                @foreach($summary['stats'] as $name => $data)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['sum'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['avg'] ?? '-' }}
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>

            <x-header>{{ __('skills.index') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Навык
                    </x-table.header>
                    <x-table.header>
                        Владение
                    </x-table.header>
                    <x-table.header>
                        Профессия
                    </x-table.header>
                    <x-table.header>
                        Мастерство
                    </x-table.header>
                    <x-table.header>
                        Сумма очков
                    </x-table.header>
                </x-slot>

                @foreach($summary['skills'] as $name => $data)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['1'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['2'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['3'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['sum'] ?? '-' }}
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>

            <x-header>{{ __('perks.index') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Название
                    </x-table.header>
                    <x-table.header>
                        Количество
                    </x-table.header>
                    <x-table.header>
                        Частота
                    </x-table.header>
                </x-slot>

                @foreach($summary['perks'] as $name => $data)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['count'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['frequency'] ?? '-' }}%
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>

            <x-header>{{ __('talents.index') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Название
                    </x-table.header>
                    <x-table.header>
                        Количество
                    </x-table.header>
                    <x-table.header>
                        Частота
                    </x-table.header>
                </x-slot>

                @foreach($summary['talents'] as $name => $data)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['count'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['frequency'] ?? '-' }}%
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>

            <x-header>{{ __('techniques.index') }}</x-header>
            <x-table>
                <x-slot name="heading">
                    <x-table.header>
                        Название
                    </x-table.header>
                    <x-table.header>
                        Количество
                    </x-table.header>
                    <x-table.header>
                        Частота
                    </x-table.header>
                </x-slot>

                @foreach($summary['techniques'] as $name => $data)
                    <x-table.row>
                        <x-table.cell>
                            {{ $name }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['count'] ?? '-' }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $data['frequency'] ?? '-' }}%
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>
        </x-card>
    </x-container>
@endsection
