<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Receivable
 *
 * @package App\Models
 * @version November 23, 2020, 10:31 am UTC
 * @property integer $restaurant_id
 * @property integer $order_id
 * @property string $delivery_name
 * @property string $status
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Resturant $order
 * @property-read \App\Models\Resturant $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable newQuery()
 * @method static \Illuminate\Database\Query\Builder|Receivable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereDeliveryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receivable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Receivable withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Receivable withoutTrashed()
 * @mixin Model
 */
class Receivable extends Model
{


    public $table = 'receivables';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'restaurant_id',
        'order_id',
        'delivery_name',
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
        'order_id' => 'integer',
        'delivery_name' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'restaurant_id' => 'required',
        'order_id' => 'delivey_name string text',
        'delivery_name' => 'required',
        'status' => 'required'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function order()
    {
        return $this->belongsTo(Resturant::class);
    }
}
