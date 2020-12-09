<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Coverage_area
 *
 * @property int $id
 * @property float $lat
 * @property float $long
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coverage_area whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Coverage_area extends Model
{
    //
    use LogsActivity;

    protected $table = 'coverage_areas';


    protected static $logName = 'area';

    protected static $logAttributes = ['lat','long','status'];

    protected $fillable = [
        'lat','long','status','created_by','updated_by'
    ];
}
