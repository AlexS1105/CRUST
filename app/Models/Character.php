<?php

namespace App\Models;

use App\Enums\CharacterGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CharacterStatus;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Kyslik\ColumnSortable\Sortable;

class Character extends Model
{
    use HasFactory, HybridRelations, Sortable;

    protected $guarded = [];

    protected $casts = [
        'status' => CharacterStatus::class,
        'gender' => CharacterGender::class,
        'info_hidden' => 'boolean',
        'bio_hidden' => 'boolean'
    ];

    public $sortable = [
        'name',
        'status_updated_at',
        'status'
    ];

    public function setStatus(CharacterStatus $status) {
        $this->status = $status;
        $this->status_updated_at = now();
        $this->save();
    }

    public function takeForApproval() {
        $this->status = CharacterStatus::Approval;
        $this->status_updated_at = now();
        $this->registrar_id = auth()->id();
        $this->save();
    }

    public function cancelApproval()
    {
        $this->status = CharacterStatus::Pending;
        $this->status_updated_at = now();
        $this->registrar_id = null;
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function charsheet()
    {
        return $this->hasOne(Charsheet::class, 'character', 'login');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function(Character $character) {
            if ($character->charsheet) {
                $character->charsheet->delete();
            }
        });
    }
}
