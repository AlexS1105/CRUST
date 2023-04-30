<?php

namespace App\Models;

use App\Enums\CharacterOrigin;
use App\Enums\CharacterStat;
use App\Enums\CharacterStatus;
use App\Services\CharacterService;
use App\Settings\CharsheetSettings;
use App\Traits\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Character
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property CharacterOrigin $gender
 * @property string $race
 * @property string $age
 * @property string|null $appearance
 * @property string|null $background
 * @property bool $info_hidden
 * @property bool $bio_hidden
 * @property string $login
 * @property int $user_id
 * @property int|null $registrar_id
 * @property CharacterStatus $status
 * @property string|null $status_updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $player_only_info
 * @property string|null $gm_only_info
 * @property int $registered
 * @property int $estitence
 * @property string|null $personality
 * @property string|null $last_idea
 *
 * @property-read Charsheet|null $charsheet
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Experience> $experiences
 * @property-read int|null $experiences_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Fate> $fates
 * @property-read int|null $fates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Idea> $ideas
 * @property-read int|null $ideas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<NarrativeCraft> $narrativeCrafts
 * @property-read int|null $narrative_crafts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<PerkVariant> $perkVariants
 * @property-read int|null $perk_variants_count
 * @property-read User|null $registrar
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Sphere> $spheres
 * @property-read int|null $spheres_count
 * @property-read Ticket|null $ticket
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|array<EstitenceLog> $estitenceLogs
 * @property-read int|null $estitence_logs_count
 *
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, $operator = '>=', $count = 1, $boolean = 'and', ?\Closure $callback = null)
 * @method static \Database\Factories\CharacterFactory factory(...$parameters)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character filter($request)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character hasPerk($perkId)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character newModelQuery()
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character newQuery()
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character query()
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character search($search, $field = 'name')
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character sortable($defaultParameters = null)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereAge($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereAppearance($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereBackground($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereBioHidden($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereCreatedAt($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereDescription($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereGender($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereGmOnlyInfo($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereId($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereInfoHidden($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereLastIdea($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereLogin($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereName($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character wherePersonality($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character wherePlayerOnlyInfo($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereRace($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereRegistered($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereRegistrarId($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereStatus($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereStatusUpdatedAt($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereUpdatedAt($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereUserId($value)
 * @method static \Jenssegers\Mongodb\Helpers\EloquentBuilder|Character whereEstitence($value)
 *
 * @mixin \Eloquent
 */
class Character extends Model
{
    use HasFactory, HybridRelations, Sortable, Searchable;

    public $sortable = [
        'name',
        'status_updated_at',
        'status',
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'origin',
        'race',
        'age',
        'legacy',
        'appearance',
        'background',
        'info_hidden',
        'bio_hidden',
        'login',
        'status',
        'status_updated_at',
        'player_only_info',
        'gm_only_info',
        'estitence',
        'personality',
        'last_idea',
        'notion_page',
        'experience',
        'estitence_reduce',
    ];

    protected $casts = [
        'status' => CharacterStatus::class,
        'origin' => CharacterOrigin::class,
        'info_hidden' => 'boolean',
        'bio_hidden' => 'boolean',
    ];

    public function scopeAffectedByEstitenceReduce($query)
    {
        return $query->where([
            ['estitence', '>', app(CharsheetSettings::class)->safe_estitence],
            ['last_online_at', '>', now()->subWeeks(2)],
            ['origin', '!=', CharacterOrigin::Incarnated],
            ['estitence_reduce', '=', true],
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasFreeIdea()
    {
        return ! isset($this->last_idea) || Carbon::now()->startOfWeek()->greaterThan(
            Carbon::createFromTimeString($this->last_idea)
        );
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

    public function perks()
    {
        return $this->belongsToMany(Perk::class, 'characters_perks')->withPivot('note');
    }

    public function estitenceLogs()
    {
        return $this->hasMany(EstitenceLog::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('level')->using(CharacterSkill::class);
    }

    public function talents()
    {
        return $this->belongsToMany(Talent::class, 'character_talent');
    }

    public function tides()
    {
        return $this->hasMany(Tide::class);
    }

    public function rumors()
    {
        return $this->hasMany(Rumor::class);
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
        $query->whereHas('perk', function ($query) use ($perkId) {
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
                $attributes = [
                    'status' => $value,
                    'status_updated_at' => now(),
                ];

                if (! $value->hasRegistrar()) {
                    $attributes['registrar_id'] = null;
                }

                return $attributes;
            },
        );
    }

    public function reference(): Attribute
    {
        return Attribute::make(
            get: function () {
                $disk = Storage::disk('characters');
                $fileName = $this->id.'/reference';

                return $disk->exists($fileName) ? $fileName : 'default/reference';
            }
        );
    }

    public function getResizedReference($size)
    {
        $disk = Storage::disk('characters');
        $fileName = $this->reference.'_'.$size;

        if (! $disk->exists($fileName)) {
            app(CharacterService::class)->resizeReference($this->reference, $size);
        }

        return $disk->url($fileName);
    }

    public function login(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (isset($this->charsheet)) {
                    $this->charsheet->character = $value;
                    $this->charsheet->save();
                }

                return $value;
            }
        );
    }

    public function notionTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->id.' '.$this->login.' | '.$this->name,
        );
    }

    public function shouldReceiveAdditionalEstitence(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->origin == CharacterOrigin::Limbborn,
        );
    }

    public function statsInequality(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->estitence - $this->charsheet->stats_sum,
        );
    }

    public function perkSum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->perks->sum('cost'),
        );
    }

    public function shouldReceiveAdditionalPerkPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->origin == CharacterOrigin::Planeborn,
        );
    }

    public function soulCoefficient(): Attribute
    {
        return Attribute::make(
            get: fn () => intval(round($this->estitence / 10)),
        );
    }

    public function shouldReceiveAdditionalSkillPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->origin == CharacterOrigin::Planeborn,
        );
    }

    public function skillSum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->skills->reduce(fn ($sum, $skill) => $sum + $skill->pivot->cost),
        );
    }

    public function talentSum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->talents->reduce(fn ($sum, $talent) => $sum + $talent->cost),
        );
    }

    public function maxTalentAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => ceil(max(2, $this->charsheet->stats[CharacterStat::Determination->value] / 2)),
        );
    }

    public function shouldReceiveAdditionalTalentPoints(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->origin == CharacterOrigin::Undead,
        );
    }

    public function registered(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_online_at != null,
        );
    }
}
