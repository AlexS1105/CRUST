<?php

namespace App\Models;

use App\Enums\CharacterGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CharacterStatus;
use App\Rules\PerkPool;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
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

    public function giveVox($amount, $reason)
    {
        if ($amount != 0) {
            $voxLog = [];
            $voxLog['character_id'] = $this->id;
            $voxLog['issued_by'] = auth()->user()->id;
            $voxLog['before'] = $this->vox;
            $voxLog['after'] = $this->vox + $amount;
            $voxLog['reason'] = $reason;
            $voxLog['delta'] = $amount;
    
            VoxLog::create($voxLog);
            $this->vox += $amount;
            $this->save();
        }
    }

    public function takeVox($amount, $reason)
    {
        return $this->giveVox(-$amount, $reason);
    }

    public function togglePerk($perkVariant)
    {
        $perkVariant = $this->perkVariants->firstWhere('id', $perkVariant->id);
        $pivot = $perkVariant->pivot;

        if ($this->vox <= 0 && !$pivot->active) {
            throw new Exception('validation.vox.not_enough');
        }
        
        $perks = [];

        foreach($this->perkVariants as $variant) {
            $perks[$variant->perk_id] = [
                'variant' => $variant,
                'active' => $variant->id === $perkVariant->id ? !$pivot->active : $variant->pivot->active,
                'note' => $variant->pivot->note
            ];
        }

        $validator = Validator::make([
            'perks' => $perks
        ], [
            'perks' => new PerkPool(true)
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$pivot->active) {
            $this->takeVox(1, 'Активация перка '.$perkVariant->perk->name);
        }

        $this->perkVariants()->detach($perkVariant->id);
        $this->perkVariants()->attach($perkVariant, ['active' => !$pivot->active, 'note' => $pivot->note]);

        info('Character perk '.($pivot->active ? 'deactivated' : 'activated'), [
            'user' => auth()->user()->login,
            'character' => $this->login,
            'perk' => $perkVariant->perk->name
        ]);

        return back();
    }

    public function hasFreeIdea()
    {
        return !isset($this->last_idea) || Carbon::now()->startOfWeek()->greaterThan(Carbon::createFromTimeString($this->last_idea));
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
        return $this->belongsToMany(PerkVariant::class, 'characters_perks')->withPivot('note', 'active');
    }

    public function fates()
    {
        return $this->hasMany(Fate::class);
    }

    public function voxLogs()
    {
        return $this->hasMany(VoxLog::class);
    }

    public function skins()
    {
        return $this->hasMany(Skin::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function spheres()
    {
        return $this->hasMany(Sphere::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function(Character $character) {
            if ($character->charsheet) {
                $character->charsheet->delete();
            }
        });

        static::created(function($character) {
            info('Character created', [
                'user' => auth()->user() != null ? auth()->user()->login : null,
                'character' => $character->login
            ]);
        });

        static::updated(function($character) {
            info('Character updated', [
                'user' => auth()->user()->login,
                'character' => $character->login
            ]);
        });

        static::deleted(function($character) {
            info('User unbanned', [
                'user' => auth()->user()->login,
                'character' => $character->login
            ]);
        });
    }
}
