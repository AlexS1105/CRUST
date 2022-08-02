<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SphereHasEnough implements Rule
{
    public $sphere;
    
    public function __construct($sphere)
    {
        $this->sphere = $sphere;
    }

    public function passes($attribute, $value)
    {
        return $this->sphere->value >= $value;
    }

    public function message()
    {
        return __('validation.sphere_not_enough');
    }
}
