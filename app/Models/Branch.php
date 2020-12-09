<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Branch
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $status
 * @property float $commission
 * @property int $supermarket_id
 * @property int $priority
 * @property string|null $image
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $state
 * @property string $start_time
 * @property string $end_time
 * @property int $area_id
 * @property int $city_id
 * @property int $country_id
 * @property int $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Area $area
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Country $country
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @property-read int|null $product_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Supermarket $supermarket
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereSupermarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{
    //

    use LogsActivity;

    protected static $logName = 'supermarket branches';

    protected static $logAttributes = ['name_ar', 'name_en', 'status', 'image', 'supermarket_id'];

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_supermarket');
    }


    public function locations()
    {
        return $this->hasMany('App\Models\BranchLocation');
    }
    

    public function supermarket()
    {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_supermarket', "branch_id");
    }

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'product_supermarket');
    }


    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
