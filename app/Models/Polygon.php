<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Polygon
 *
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property int $area_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Polygon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Polygon extends Model
{
    protected $guarded =[];

    public function area()
    {
    	return $this->belongsTo('App\Models\Area');
    }
}
