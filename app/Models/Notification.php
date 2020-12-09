<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $arab_title
 * @property string $eng_title
 * @property string $arab_body
 * @property string $eng_body
 * @property string $icon
 * @property int $flag
 * @property int|null $model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereArabBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereArabTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereEngBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereEngTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'title','body','icon','flag','model_id','created_by','updated_by'
    ];

}
