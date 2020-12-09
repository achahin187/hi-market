<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Clientdevice
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Clientdevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientdevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clientdevice query()
 * @mixin \Eloquent
 */
class Clientdevice extends Model
{
    //

    protected $fillable = [
        'remember_token','udid'
    ];
}
