<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Reason
 *
 * @property int $id
 * @property string $eng_reason
 * @property string $arab_reason
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereArabReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereEngReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Reason extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'reason';

    protected static $logAttributes = ['arab_reason','eng_reason','status',];

    protected $fillable = [
        'arab_reason','eng_reason','status','created_by','updated_by'
    ];

       protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_reason : $this->arab_reason;
    }
}
