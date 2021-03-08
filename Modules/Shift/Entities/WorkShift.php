<?php

namespace Modules\Shift\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShift extends Model
{
    use SoftDeletes;
    protected $fillable = ['id'];
    protected $table = 'shift'; 

    public function user()
    {
        // return $this->hasOne('Modules\Shift\Entities\User', 'id', 'user_id');
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
}
