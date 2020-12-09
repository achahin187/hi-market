<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\SubCategory
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property string|null $image
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class SubCategory extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'subcategories';

    protected static $logAttributes = ['image','arab_name','eng_name','category_id',];

    protected $table = 'subcategories';

    protected $fillable = [
        'image','arab_name','eng_name','category_id','created_by','updated_by'
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }


}
