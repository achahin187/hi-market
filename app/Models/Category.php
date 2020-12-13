<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Branch $branch
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Supermarket[] $supermarkets
 * @property-read int|null $supermarkets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor[] $vendors
 * @property-read int|null $vendors_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Branch[] $branches
 * @property-read int|null $branches_count
 */
class Category extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'category';

    protected static $logAttributes = ['image', 'name_ar', 'name_en',];

    protected $fillable = [
        'image', 'name_ar', 'name_en', 'created_by', 'updated_by'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    // public function vendors()
    // {
    //     return $this->hasMany('App\Models\Vendor');
    // }
    public function vendors() {
        return $this->belongsToMany('App\Models\Vendor','category_vendor');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Models\Subcategory');
    }

    public function branches()
    {
        return $this->belongsToMany('App\Models\Branch', 'category_supermarket', "category_id");
    }

    public function supermarkets()
    {
        return $this->belongsToMany('App\Models\Supermarket');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
}
