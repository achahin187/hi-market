<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;

/**
 * App\Models\Systemlog
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property int|null $subject_id
 * @property string|null $subject_type
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property Collection|null $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $causer
 * @property-read Collection $changes
 * @property-read Model|\Eloquent $subject
 * @method static Builder|Systemlog causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static Builder|Systemlog forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static Builder|Systemlog inLog($logNames)
 * @method static Builder|Systemlog newModelQuery()
 * @method static Builder|Systemlog newQuery()
 * @method static Builder|Systemlog query()
 * @method static Builder|Systemlog whereCauserId($value)
 * @method static Builder|Systemlog whereCauserType($value)
 * @method static Builder|Systemlog whereCreatedAt($value)
 * @method static Builder|Systemlog whereDescription($value)
 * @method static Builder|Systemlog whereId($value)
 * @method static Builder|Systemlog whereLogName($value)
 * @method static Builder|Systemlog whereProperties($value)
 * @method static Builder|Systemlog whereSubjectId($value)
 * @method static Builder|Systemlog whereSubjectType($value)
 * @method static Builder|Systemlog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Systemlog extends Model implements ActivityContract
{
    public $guarded = [];

    protected $casts = [
        'properties' => 'collection',
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($this->connection)) {
            $this->setConnection(config('activitylog.database_connection'));
        }

        if (! isset($this->table)) {
            $this->setTable(config('activitylog.table_name'));
        }

        parent::__construct($attributes);
    }

    public function subject(): MorphTo
    {
        if (config('activitylog.subject_returns_soft_deleted_models')) {
            return $this->morphTo()->withTrashed();
        }

        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function getExtraProperty(string $propertyName)
    {
        return Arr::get($this->properties->toArray(), $propertyName);
    }

    public function changes(): Collection
    {
        if (! $this->properties instanceof Collection) {
            return new Collection();
        }

        return $this->properties->only(['attributes', 'old']);
    }

    public function getChangesAttribute(): Collection
    {
        return $this->changes();
    }

    public function scopeInLog(Builder $query, ...$logNames): Builder
    {
        if (is_array($logNames[0])) {
            $logNames = $logNames[0];
        }

        return $query->whereIn('log_name', $logNames);
    }

    public function scopeCausedBy(Builder $query, Model $causer): Builder
    {
        return $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }
}
