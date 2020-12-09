<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Offer
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property string|null $eng_description
 * @property string|null $arab_description
 * @property string|null $value_type
 * @property string|null $offer_type
 * @property float|null $money
 * @property int|null $points
 * @property string|null $promocode
 * @property int $supermarket_id
 * @property int $branch_id
 * @property string|null $image
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Branch $branch
 * @property-read mixed $description
 * @property-read mixed $name
 * @property-read \App\Models\Supermarket $supermarket
 * @method static \Illuminate\Database\Eloquent\Builder|Offer checkPromoCode($promoCode)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer checkSuperMarket($supermarket_id)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereArabDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereOfferType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer wherePromocode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereSupermarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereValueType($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'offer';

    protected static $logAttributes = ['arab_name', 'eng_name', 'arab_description', 'eng_description', 'offer_type', 'promocode', 'status', 'end_date', 'start_date', 'value_type', 'supermarket_id', 'branch_id'];

    protected $fillable = [
        'arab_name', 'eng_name', 'arab_description', 'eng_description', 'offer_type', 'promocode', 'status', 'end_date', 'start_date', 'value_type', 'supermarket_id', 'branch_id', 'image', 'created_by', 'updated_by'
    ];

    public function scopeCheckPromoCode($q, $promoCode)
    {
        return $q->Where('promocode', $promoCode);
    }

    public function scopeCheckSuperMarket($q, $supermarket_id)
    {
        return $q->Where('supermarket_id', $supermarket_id);
    }

    public function supermarket()
    {
        return $this->belongsTo('App\Models\Supermarket');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_description : $this->arab_description;
    }

      public function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->eng_name  : $this->arab_name;
    }
}
