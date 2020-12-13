<?php

namespace App\Models;

use App\Pipeline\CreatedAt;
use App\Pipeline\Name;
use App\Pipeline\Status;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string|null $mobile_delivery
 * @property string $address
 * @property float|null $rate
 * @property string $delivery_date
 * @property float|null $delivery_rate
 * @property string|null $client_review
 * @property string|null $review_status
 * @property float|null $order_price
 * @property int $status
 * @property int $client_id
 * @property int|null $request
 * @property string|null $approved_at
 * @property string|null $prepared_at
 * @property string|null $shipping_at
 * @property string|null $shipped_at
 * @property string|null $rejected_at
 * @property string|null $received_at
 * @property string|null $cancelled_at
 * @property int $admin_cancellation
 * @property int|null $reason_id
 * @property string|null $notes
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAdminCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMobileDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePreparedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRejectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{

    use LogsActivity, HasFilter;

    public $queryFilters = [

        Status::class,
        CreatedAt::class
    ];
    protected static $logName = 'order';

    protected static $logAttributes = ['review_status', 'client_review', 'mobile_delivery', 'address', 'client_id', 'status', 'order_date', 'delivery_date', 'delivery_rate', 'order_price', 'request', 'approved_at', 'prepared_at', 'shipping_at', 'shipped_at', 'rejected_at', 'received_at', 'cancelled_at', 'user_id', 'admin_cancellation', 'reason_id', 'notes',];

    protected $fillable = [
        'review_status', 'client_review', 'mobile_delivery', 'address', 'client_id', 'status', 'order_date', 'delivery_date', 'delivery_rate', 'order_price', 'request', 'approved_at', 'prepared_at', 'shipping_at', 'shipped_at', 'rejected_at', 'received_at', 'cancelled_at', 'user_id', 'admin_cancellation', 'reason_id', 'notes', 'created_by', 'updated_by'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity', 'price');
    }

    // public function companies()
    // {
    //     return $this->belongsToMany(DeliveryCompany::class,"company_order");
    // }
}
