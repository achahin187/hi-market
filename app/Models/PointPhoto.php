<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PointPhoto
 *
 * @property int $id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointPhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PointPhoto extends Model
{
    protected $guarded = [];
}
