<?php

namespace Database\Seeders;

use App\Models\Advantage;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = Skill::factory(32)->create();
        $levels = [
            3,
            9,
            13,
            18,
        ];

        foreach ($skills as $skill) {
            foreach ($levels as $level) {
                Advantage::factory()->create([
                    'skill_id' => $skill->id,
                    'level' => $level,
                    'is_penalty' => !$skill->proficiency && $level == 3,
                ]);
            }
        }
    }
}
