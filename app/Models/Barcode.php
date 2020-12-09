<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Barcode
 *
 * @property int $id
 * @property int $supermarket_id
 * @property int $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode whereSupermarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barcode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barcode extends Model
{
    protected $guarded = [];


    #relations
    public function barcode()
    {
       return $this->belogngsTo('App\Models\Supermarket'); 
    }

}
