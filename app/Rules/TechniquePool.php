<?php

namespace App\Rules;

use App\Models\Technique;
use Illuminate\Contracts\Validation\Rule;

class TechniquePool implements Rule
{
    public $message = 'validation.technique_pool.invalid';
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        $character = $this->character;
        $maxTechniques = $character->max_technique_amount;
        $techniquePoints = $character->technique_points;

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $techniquePoints = request('technique_points', $techniquePoints);
            $maxTechniques = request('techniques_amount', $maxTechniques);
        }

        $techniques = Technique::all();

        $techniqueAmount = count($value);
        $techniqueSum = 0;

        foreach ($value as $techniqueId => $techniqueData) {
            $technique = $techniques->firstWhere('id', $techniqueId);

            if ($technique != null) {
                $techniqueSum += $technique->cost;
            } else {
                $this->message = 'validation.technique_pool.invalid';

                return false;
            }
        }

        if ($techniqueAmount > $maxTechniques) {
            $this->message = 'validation.technique_pool.too_much';

            return false;
        }

        if ($techniqueSum > $techniquePoints) {
            $this->message = 'validation.technique_pool.no_points';

            return false;
        }

        return true;
    }

    public function message()
    {
        return __($this->message);
    }
}
