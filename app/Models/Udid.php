<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Udid
 *
 * @property int $id
 * @property string $body
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Udid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Udid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Udid query()
 * @method static \Illuminate\Database\Eloquent\Builder|Udid whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Udid whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Udid whereId($value)
 * @mixin \Eloquent
 */
class Udid extends Model
{
    public $timestamps = false;
    protected $fillable = ["body","client_id","lat","lon"];
}
