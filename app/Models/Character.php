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

        if (!$this->registered && $status->value === CharacterStatus::Approved) {
            $this->registered = true;
        }

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

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function narrativeCrafts()
    {
        return $this->hasMany(NarrativeCraft::class);
    }

    public function perkVariants()
    {
        return $this->belongsToMany(PerkVariant::class, 'characters_perks')->withPivot('cost_offset', 'note');
    }

    public function traits()
    {
        return $this->belongsToMany(RaceTrait::class, 'characters_race_traits')->withPivot('note');
    }

    public function trait()
    {
        return $this->traits->firstWhere('subtrait', false);
    }

    public function subtrait()
    {
        return $this->traits->firstWhere('subtrait', true);
    }

    public function fates()
    {
        return $this->hasMany(Fate::class);
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
