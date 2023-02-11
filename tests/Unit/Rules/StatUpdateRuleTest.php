<?php

namespace Rules;

use App\Models\Character;
use App\Models\Charsheet;
use App\Models\User;
use App\Rules\StatUpdate;
use Tests\TestCase;

class StatUpdateRuleTest extends TestCase
{
    /**
     * @dataProvider stats
     */
    public function test_rule($before, $after, $assert)
    {
        $character = Character::factory()
            ->for(User::factory()->create())
            ->hasCharsheet(Charsheet::factory()->create())
            ->create(['estitence' => 59]);
        $character->charsheet()->update(['stats' => $before]);
        $character->load('charsheet');
        $rule = new StatUpdate($character);

        $passes = $rule->passes('stats', $after);

        $this->assertEquals($assert, $passes);
    }

    public function stats()
    {
        return [
            [
                [
                    'strength'      => 11,
                    'endurance'     => 4,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                [
                    'strength'      => 10,
                    'endurance'     => 5,
                    'perception'    => 7,
                    'agility'       => 9,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                false,
            ],
            [
                [
                    'strength'      => 11,
                    'endurance'     => 4,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                [
                    'strength'      => 10,
                    'endurance'     => 5,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                true,
            ],
            [
                [
                    'strength'      => 10,
                    'endurance'     => 4,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                [
                    'strength'      => 10,
                    'endurance'     => 5,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                true,
            ],
            [
                [
                    'strength'      => 10,
                    'endurance'     => 4,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                [
                    'strength'      => 11,
                    'endurance'     => 5,
                    'perception'    => 8,
                    'agility'       => 7,
                    'determination' => 7,
                    'erudition'     => 7,
                    'will'          => 7,
                    'potential'     => 7,
                ],
                false,
            ],
            [
                [
                    'strength'      => 20,
                    'endurance'     => 7,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 19,
                    'endurance'     => 8,
                    'perception'    => 8,
                    'agility'       => 8,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                true,
            ],
            [
                [
                    'strength'      => 20,
                    'endurance'     => 7,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 19,
                    'endurance'     => 10,
                    'perception'    => 8,
                    'agility'       => 6,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                false,
            ],
            [
                [
                    'strength'      => 20,
                    'endurance'     => 7,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 18,
                    'endurance'     => 7,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 3,
                    'will'          => 3,
                    'potential'     => 3,
                ],
                false,
            ],
            [
                [
                    'strength'      => 20,
                    'endurance'     => 7,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 20,
                    'endurance'     => 5,
                    'perception'    => 7,
                    'agility'       => 7,
                    'determination' => 2,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                false,
            ],
            [
                [
                    'strength'      => 16,
                    'endurance'     => 14,
                    'perception'    => 8,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 15,
                    'endurance'     => 15,
                    'perception'    => 8,
                    'agility'       => 7,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                true,
            ],
            [
                [
                    'strength'      => 21,
                    'endurance'     => 13,
                    'perception'    => 1,
                    'agility'       => 1,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                [
                    'strength'      => 20,
                    'endurance'     => 14,
                    'perception'    => 1,
                    'agility'       => 1,
                    'determination' => 1,
                    'erudition'     => 1,
                    'will'          => 1,
                    'potential'     => 1,
                ],
                true,
            ],
        ];
    }
}
