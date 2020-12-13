<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Payable
 *
 * @package App\Models
 * @version November 23, 2020, 10:32 am UTC
 * @property integer $restaurant_id
 * @property string $status
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order_id
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Resturant $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Payable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payable newQuery()
 * @method static \Illuminate\Database\Query\Builder|Payable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Payable withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Payable withoutTrashed()
 * @mixin Model
 */
class Payable extends Model
{


    public $table = 'payables';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'restaurant_id',
        "order_id",
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'restaurant_id' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'restaurant_id' => 'required',
        'status' => 'required'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
