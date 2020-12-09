<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $arab_name
 * @property string $eng_name
 * @property string|null $eng_description
 * @property string|null $arab_description
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Systemlog[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereArabDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereArabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereEngDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereEngName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Team extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'teams';

    protected static $logAttributes = ['arab_name','eng_name','arab_description','eng_description','role_id'];

    protected $fillable = [
        'arab_name','eng_name','arab_description','eng_description','created_by','role_id','updated_by'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
}
