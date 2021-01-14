<?php

namespace App\Models;

use App\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $total_points
 * @property string|null $address
 * @property string|null $mobile_number
 * @property string|null $unique_id
 * @property string|null $activation_code
 * @property string|null $image
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $productsreview
 * @property-read int|null $productsreview_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereActivationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereTotalPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Client extends Authenticatable
{

    use LogsActivity, HasApiTokens;


    protected static $logName = 'client';

    protected static $logAttributes = ['status', 'password', 'name', 'email', 'mobile_number', 'address','image'];

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('udid');
    }

    public function productsreview()
    {
        return $this->belongsToMany('App\Models\Product', 'client_reviews')->withPivot('review');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }


    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,"user_id");
    }

    public function setPasswordAttribute($value){

        $this->attributes['password'] = Hash::make($value);
    }

    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }

}
