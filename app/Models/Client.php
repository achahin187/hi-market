<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable
{

    use LogsActivity,HasApiTokens;


    protected static $logName = 'client';

    protected static $logAttributes = ['status','password','name','email','mobile_number','address','image'];

    protected $guarded =[];

    protected $hidden = [
        'password','remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product')->withPivot('udid');
    }

    public function productsreview() {
        return $this->belongsToMany('App\Models\Product','client_reviews')->withPivot('review');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }


    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
