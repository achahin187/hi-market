<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    //
    use LogsActivity;


    protected $fillable = [
        'password','name','email','age','mobile_number','address','city','status','gender','unique_id','device_token','total_points','created_by','updated_by'
    ];

    protected $hidden = [
        'password', 'remember_token',
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
        return $this->belongsToMany('App\Models\Product')->withPivot('flag');
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
