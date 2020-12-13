<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $govern
 * @property string $description
 * @property int $default
 * @property string $address_lable
 * @property string $lat
 * @property string $lon
 * @property string|null $additional
 * @property int $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $verify
 * @property string|null $verified
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddressLable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereGovern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereVerify($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    //
    use LogsActivity;

    protected $table = 'addresses';

    protected static $logName = 'address';

    protected static $logAttributes = ['description','client_id'];

    protected $guarded = [];



    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
