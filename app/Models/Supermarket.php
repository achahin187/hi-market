<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Supermarket
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property string $status
 * @property float $commission
 * @property string|null $image
 * @property string|null $logo_image
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barcode|null $Barcode
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Area $area
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Branch[] $branches
 * @property-read int|null $branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket selection()
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereLogoImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supermarket whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Supermarket extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'supermarkets';

    protected static $logAttributes = ['arab_name','eng_name','status','commission','priority','image'];

    protected $fillable = [
        'arab_name','eng_name','status','commission','priority','image','logo_image','area_id','city_id','country_id','start_time','end_time','state','created_by','updated_by'
    ];



    public function products() {
        return $this->hasMany('App\Models\Product');
    }

    public function Barcode()
    {
       return $this->hasOne('App\Models\Barcode'); 
    }

    public function offers() {
        return $this->hasMany('App\Models\Offer');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }

    public function branches() {
        return $this->belongsToMany('App\Models\Branch');
    }

    public function area() {
        return $this->belongsTo('App\Models\Area');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country');
    }

    public function user() {
        return $this->belongsTo('App\User','created_by','id');
    }



    public function scopeSelection($query)
    {
        return $query->select('arab_name','eng_name','commission','start_time','end_time','state');
    }
    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_name : $this->arab_name;
    }
}
