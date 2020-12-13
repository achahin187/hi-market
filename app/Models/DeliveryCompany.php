<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeliveryCompany
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string|null $open_time
 * @property string|null $close_time
 * @property int $status
 * @property float $commission
 * @property array $phone_number
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $city_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Branch[] $branches
 * @property-read int|null $branches_count
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereCloseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereOpenTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryCompany whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeliveryCompany extends Model
{
    protected $fillable = ["commission", "name_ar", "name_en", "status", "email", "phone_number",'city_id'];
    protected $casts = [
        'phone_number' => 'array'
    ];


    protected function getNameAttribute()
    {
        return app()->getLocale() == "en" ? $this->name_en : $this->name_ar;
    }
    
    public function branches()
    {
        return $this->belongsToMany(Branch::class,"delivery_companies_branches");
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'company_id');
    }
}
