<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SubCategory extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'subcategories';

    protected static $logAttributes = ['image','arab_name','eng_name','category_id',];

    protected $table = 'subcategories';

    protected $fillable = [
        'image','arab_name','eng_name','category_id','created_by','updated_by'
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }


}
