<?php

namespace App\Models;

use App\Pipeline\LastSevenDays;
use App\Pipeline\LastSixtyDays;
use App\Pipeline\LastThirtyDays;
use App\Pipeline\LowPrice;
use App\Pipeline\MostPopular;
use App\Pipeline\CategoryId;
use App\Pipeline\HighPrice;
use App\Pipeline\Vendor;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string|null $eng_description
 * @property string|null $arab_description
 * @property string|null $eng_spec
 * @property string|null $arab_spec
 * @property float|null $price
 * @property float|null $offer_price
 * @property float|null $rate
 * @property int|null $ratings
 * @property int|null $priority
 * @property string|null $images
 * @property int|null $points
 * @property int|null $category_id
 * @property int|null $vendor_id
 * @property int|null $supermarket_id
 * @property int|null $branch_id
 * @property int|null $measure_id
 * @property int|null $size_id
 * @property int $flag
 * @property string $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $exp_date
 * @property string $production_date
 * @property string $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $views
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Branch[] $branches
 * @property-read int|null $branches_count
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clientreviews
 * @property-read int|null $clientreviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Measures|null $measure
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Size|null $size
 * @property-read \App\Models\SubCategory $subcategory
 * @property-read \App\Models\Supermarket|null $supermarket
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|Product filter()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product similar($categories, $supermarket_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArabDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArabSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEngSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMeasureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRatings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSupermarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVendorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViews($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
    use LogsActivity,HasFilter;
    protected $queryFilters= [

        Vendor::class,
        MostPopular::class,
        HighPrice::class,
        LowPrice::class,
        LastSevenDays::class,
        LastThirtyDays::class,
        LastSixtyDays::class,
        CategoryId::class
    ];

    protected static $logName = 'products';
    protected $table = 'products';

    // protected static $logAttributes = ['arab_name','eng_name','price','offer_price','images','category_id','vendor_id','supermarket_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','ratings','eng_spec','arab_spec','rate','exp_date','points','priority','barcode','production_date'];

    protected static $logAttributes = ['name_ar','name_en','price','offer_price','images','category_id','vendor_id','supermarket_id','subcategory_id','arab_description','eng_description','flag','status','start_date','end_date','measure_id','size_id','subcategory_id','ratings','eng_spec','arab_spec','rate','exp_date','points','priority','barcode','production_date'];

    protected $guarded = [];

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function vendor() {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function supermarket() {
        return $this->belongsTo('App\Models\Supermarket');
    }

   
    public function measure() {
        return $this->belongsTo('App\Models\Measures', 'meas');
    }

     public function city() {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function size() {
        return $this->belongsTo('App\Models\Size');
    }

    public function clients() {
        return $this->belongsToMany('App\Models\Client');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order');
    }

    // public function branch() {
    //     return $this->belongsTo('App\Models\Branch');
    // }

    public function clientreviews() {
        return $this->belongsToMany('App\Models\Client','client_reviews');
    }

    public function branches() {
        return $this->belongsToMany('App\Models\Branch','product_supermarket');
    }

    // public function getBranch()
    // {
    //     return $this->branches()->get();
    // }




    protected function getNameAttribute()
    {

        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
    protected function getDescriptionAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_description : $this->arab_description;
    }

    protected function getSpecsAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_spec : $this->arab_spec;
    }
    public function scopeSimilar($query,$categories,$supermarket_id)
    {
       $product =  explode(":", request("products") );

        $cart = [];

        foreach (explode(",", request("products")) as $index => $product) {

            $cart[]=  explode(":", $product)[0];


        }


       $query->whereIn('category_id', $categories)->whereHas("branches",function ($query) use($supermarket_id, $cart){

           $query->where("branches.id",$supermarket_id)->whereNotIn('product_id', $cart );
       });
    }
    public function favourite()
    {
        return $this->hasOne(ClientProduct::class,"product_id")->where("udid",request()->header( "udid"));
    }

}
