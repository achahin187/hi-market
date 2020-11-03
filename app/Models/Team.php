<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'teams';

    protected static $logAttributes = ['arab_name','eng_name','arab_description','eng_description'];

    protected $fillable = [
        'arab_name','eng_name','arab_description','eng_description','created_by','updated_by'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
}
