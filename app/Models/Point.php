<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Point
 *
 * @property int $id
 * @property int $points
 * @property int $type
 * @property string|null $offer_type
 * @property float $value
 * @property string $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Point newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Point newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Point query()
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereOfferType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereValue($value)
 * @mixin \Eloquent
 */
class Point extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'points';

    protected static $logAttributes = ['points','offer_type','type','value','status','end_date','start_date'];

    protected $fillable = [
        'points','type','offer_type','value','status','end_date','start_date','created_by','updated_by'
    ];
}
