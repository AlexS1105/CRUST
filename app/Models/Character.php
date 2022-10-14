<?php

namespace App\Models;

use App\Enums\CharacterGender;
use App\Enums\CharacterStatus;
use App\Rules\PerkPool;
use App\Traits\Searchable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Kyslik\ColumnSortable\Sortable;

class Character extends Model
{
    use HasFactory, HybridRelations, Sortable, Searchable;

    public $sortable = [
        'name',
        'status_updated_at',
        'status',
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => CharacterStatus::class,
        'gender' => CharacterGender::class,
        'info_hidden' => 'boolean',
        'bio_hidden' => 'boolean',
    ];

    public function giveVox($amount, $reason)
    {
        if ($amount !== 0) {
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

        if ($this->vox <= 0 && ! $pivot->active) {
            throw new Exception('validation.vox.not_enough');
        }

        $perks = [];

        foreach ($this->perkVariants as $variant) {
            $perks[$variant->perk_id] = [
                'variant' => $variant,
                'active' => $variant->id === $perkVariant->id ? ! $pivot->active : $variant->pivot->active,
                'note' => $variant->pivot->note,
            ];
        }

        $validator = Validator::make([
            'perks' => $perks,
        ], [
            'perks' => new PerkPool(true),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (! $pivot->active) {
            $this->takeVox(1, 'Активация перка '.$perkVariant->perk->name);
        }

        $this->perkVariants()->detach($perkVariant->id);
        $this->perkVariants()->attach($perkVariant, ['active' => ! $pivot->active, 'note' => $pivot->note]);

        info('Character perk '.($pivot->active ? 'deactivated' : 'activated'), [
            'user' => auth()->user()->login,
            'character' => $this->login,
            'perk' => $perkVariant->perk->name,
        ]);

        return back();
    }

    public function hasFreeIdea()
    {
        return ! isset($this->last_idea) || Carbon::now()->startOfWeek()->greaterThan(Carbon::createFromTimeString($this->last_idea));
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

    public function scopeFilter($query, $request)
    {
        $query->search($request->search);

        if ($request->has('perk')) {
            $query->hasPerk($request->perk);
        }
    }

    public function scopeHasPerk($query, $perkId)
    {
        $query->whereHas('perkVariants', function ($query) use ($perkId) {
            $query->where('perk_id', $perkId);
        });
    }

    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                $this->status_updated_at = now();

                return $value;
            }
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Character $character) {
            if ($character->charsheet) {
                $character->charsheet->delete();
            }
        });

        static::created(function ($character) {
            info('Character created', [
                'user' => auth()->user() !== null ? auth()->user()->login : null,
                'character' => $character->login,
            ]);
        });

        static::updated(function ($character) {
            info('Character updated', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        });

        static::deleted(function ($character) {
            info('User unbanned', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        });
    }
}
