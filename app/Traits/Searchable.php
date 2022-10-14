<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $search, $field="name")
    {
        if (isset($search)) {
            return $query->where($field, 'like', "%{$search}%");
        }
    }
}