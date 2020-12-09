<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Measures
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Measures newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measures newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measures query()
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measures whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Measures extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'measuring point';

    protected static $logAttributes = ['arab_name','eng_name',];

    protected $fillable = [
        'arab_name','eng_name','created_by','updated_by'
    ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
