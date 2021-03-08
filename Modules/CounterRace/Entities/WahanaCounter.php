<?php

namespace Modules\CounterRace\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  WahanaCounter extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'wahana__counter';
    public function device()
    {
        return $this->hasOne('Modules\Wahana\Entities\WahanaDevices', 'id', 'device_id');
    }
    
}
