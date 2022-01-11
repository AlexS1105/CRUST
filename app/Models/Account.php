<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        parent::boot();

        static::created(function($account) {
            info('User account created', [
                'user' => auth()->user()->login,
                'account' => $account->login
            ]);
        });

        static::deleted(function($account) {
            info('User account deleted', [
                'user' => auth()->user()->login,
                'account' => $account->login
            ]);
        });
    }
}
