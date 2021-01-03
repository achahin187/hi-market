<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property int $tax
 * @property float $tax_value
 * @property int $tax_on_product
 * @property float $delivery
 * @property int $cancellation
 * @property string|null $splash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSplash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTaxOnProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTaxValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'settings';

    protected static $logAttributes = ['tax','tax_on_product','delivery','tax_value','cancellation','splash','reedem_point'];

    protected $fillable = [
        'tax','tax_on_product','delivery','tax_value','cancellation','splash','created_by','updated_by'
    ];
}
