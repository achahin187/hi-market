<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
        'password','name','email','mobile_number','address','unique_id','total_points'
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


}
