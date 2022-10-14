<?php

namespace App\Rules;

use App\Models\Experience;
use Illuminate\Contracts\Validation\Rule;

class SphereToExperience implements Rule
{
    public $sphere;
    public $inc;

    public $message = 'validation.sphere_not_enough';

    public function __construct($sphere, $inc)
    {
        $this->sphere = $sphere;
        $this->inc = $inc;
    }

    public function passes($attribute, $value)
    {
        $experience = Experience::find($value);

        if (! isset($experience)) {
            $this->message = 'validation.sphere.invalid';

            return false;
        }

        if ($experience->level + $this->inc > 10) {
            $this->message = 'validation.sphere.experience_max';

            return false;
        }

        return $this->sphere->value >= Experience::getCost($experience->value, $this->inc);
    }

    public function message()
    {
        return __($this->message);
    }
}
