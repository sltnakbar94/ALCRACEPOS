<?php

namespace Modules\CounterRace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WahanaDevices extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'wahana__devices';
    
    public function counter()
    {
        return $this->hasMany('Modules\Wahana\Entities\WahanaCounter', 'device_id', 'id');
    }
}
