<?php

namespace Modules\Wahana\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WahanaDevices extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'wahana__devices';

    public function counter()
    {
        return $this->hasOne('Modules\Wahana\Entities\WahanaCounter', 'device_id', 'id');
    }
    public function counters()
    {
        return $this->hasMany('Modules\Wahana\Entities\WahanaCounter', 'device_id', 'id');
    }
}
