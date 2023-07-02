<?php

namespace App\Services;

use App\Enums\CharacterStat;
use App\Enums\CharacterStatus;
use App\Models\Character;
use Illuminate\Support\Arr;

class StatisticsService
{
    public function summary()
    {
        $characters = $this->getCharacters();
        $summary = collect();
        $this->general($summary, $characters);
        $this->origin($summary, $characters);
        $this->estitence($summary, $characters);
        $this->stats($summary, $characters);
        $this->skills($summary, $characters);
        $this->relations($summary, $characters, 'perks');
        $this->relations($summary, $characters, 'talents');
        $this->relations($summary, $characters, 'techniques');

        return $summary;
    }

    private function getCharacters()
    {
        return Character::with('charsheet', 'skills', 'perks', 'talents', 'techniques')
            ->where('is_technical', false)
            ->whereNotIn('status', [CharacterStatus::Blank, CharacterStatus::Deleting])
            ->get();
    }

    private function general($summary, $characters)
    {
        $summary['characters_count'] = $characters->count();
        $summary['characters_approved'] = $characters->where('status', CharacterStatus::Approved)->count();
        $summary['characters_process'] = $characters->whereNotIn('status', CharacterStatus::Approved)->count();
        $summary['characters_approved_percentage'] = round($summary['characters_approved'] / $summary['characters_count'], 4) * 100;
        $summary['characters_process_percentage'] = round($summary['characters_process'] / $summary['characters_count'], 4) * 100;
    }

    private function origin($summary, $characters)
    {
        $summary['origins'] = $characters->countBy(fn ($character) => $character->origin->localized());
        $sum = $summary['origins']->sum();
        $summary['origins_percentage'] = $summary['origins']->map(fn ($item) => round($item / $sum, 4) * 100);
    }

    private function estitence($summary, $characters)
    {
        $summary['estitence_sum'] = $characters->sum('estitence');
        $summary['estitence_avg'] = round($characters->avg('estitence'), 2);
        $summary['estitence_min'] = $characters->min('estitence');
        $summary['estitence_max'] = $characters->max('estitence');
        $summary['estitence_min_characters'] = $characters->where('estitence', $summary['estitence_min']);
        $summary['estitence_max_characters'] = $characters->where('estitence', $summary['estitence_max']);
    }

    private function stats($summary, $characters)
    {
        $summary['stats'] = collect();

        foreach (CharacterStat::cases() as $stat) {
            $data = collect();
            $data['sum'] = $characters->sum(fn ($character) => $character->charsheet?->stats[$stat->value] ?? 0);
            $data['avg'] = round($characters->avg(fn ($character) => $character->charsheet?->stats[$stat->value] ?? 0), 2);
            $summary['stats'][$stat->localized()] = $data;
        }
    }

    private function skills($summary, $characters)
    {
        $skills = [];

        foreach ($characters as $character) {
            foreach ($character->skills as $skill) {
                $sum = $skills[$skill->name]['sum'] ?? 0;
                $level = $skills[$skill->name][$skill->pivot->level] ?? 0;

                Arr::set($skills, $skill->name . '.sum', $sum + $skill->pivot->cost);
                Arr::set($skills, $skill->name . '.' . $skill->pivot->level, $level + 1);
            }
        }

        $summary['skills'] = $skills;
    }

    private function relations($summary, $characters, $relation)
    {
        $items = collect();

        foreach ($characters as $character) {
            foreach ($character->$relation as $item) {
                $data = $items[$item->name] ?? [
                    'count' => 0,
                    'frequency' => 0,
                ];

                $data['count']++;

                $items[$item->name] = $data;
            }
        }

        $sum = $items->sum('count');
        $items = $items->map(function ($data) use ($sum) {
            $data['frequency'] = round($data['count'] / $sum, 4) * 100;

            return $data;
        });

        $summary[$relation] = $items;
    }
}
