<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Area
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $status
 * @property int $country
 * @property int $city
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\City $areacity
 * @property-read \App\Models\Country $areacountry
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Supermarket[] $supermarkets
 * @property-read int|null $supermarkets_count
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Area extends Model
{
    //

    use LogsActivity;


    protected static $logName = 'area';

    protected static $logAttributes = ['name_ar','name_en','city','country','status'];

    protected $guarded=[];


    public function areacountry() {
        return $this->belongsTo('App\Models\Country','country');
    }


    public function areacity() {
        return $this->belongsTo('App\Models\City','city');
    }

    public function polygon() {
        return $this->hasMany('App\Models\Polygon');
    }

    public function supermarkets() {
        return $this->hasMany('App\Models\Branch');
    }
}
