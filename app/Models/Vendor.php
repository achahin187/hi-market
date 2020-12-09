<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property string|null $image
 * @property int $sponsor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereSponsor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'vendors';

    protected static $logAttributes = ['arab_name', 'eng_name', 'image', 'category_id', 'subcategory_id', 'sponsor'];

    protected $fillable = [
        'arab_name', 'eng_name', 'image', 'category_id', 'subcategory_id', 'sponsor', 'created_by', 'updated_by'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_vendor');
    }

    // public function subcategory() {
    //     return $this->belongsTo('App\Models\SubCategory');
    // }
    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_name : $this->arab_name;
    }

}
