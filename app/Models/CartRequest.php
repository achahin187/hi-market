<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\CartRequest
 *
 * @property int $id
 * @property string $cart_description
 * @property string $address
 * @property int $client_id
 * @property int $converted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereCartDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereConverted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartRequest whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class CartRequest extends Model
{
    //
    use LogsActivity;

    protected $fillable = [
        'cart_description','address','client_id','converted','created_by','updated_by'
    ];

    public function client() {
        return $this->belongsTo('App\Models\Client');
    }

}
