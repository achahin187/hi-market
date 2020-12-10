<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $status
 * @property int $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Area[] $areaList
 * @property-read int|null $area_list_count
 * @property-read \App\Models\Country $citycountry
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Supermarket[] $supermarkets
 * @property-read int|null $supermarkets_count
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    //
    use LogsActivity;


    protected static $logName = 'city';

    protected static $logAttributes = ['name_ar','name_en','country','status'];

    protected $fillable = [
        'name_ar','name_en','country','status','created_by','updated_by'
    ];

    public function citycountry() {
        return $this->belongsTo('App\Models\Country','country');
    }

    public function locations() {
        return $this->hasMany('App\Models\Location','city_id');
    }

    public function areaList() {
        return $this->hasMany('App\Models\Area','city');
    }

    public function supermarkets() {
        return $this->hasMany('App\Models\Supermarket');
    }
    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
