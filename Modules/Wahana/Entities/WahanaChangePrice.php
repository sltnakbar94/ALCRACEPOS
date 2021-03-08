<?php

namespace Modules\Wahana\Entities;

use Illuminate\Database\Eloquent\Model;

class WahanaChangePrice extends Model
{
    protected $fillable = [];
    protected $table = 'wahana__changeprice';

    public function item()
    {
        return $this->hasOne('Modules\Wahana\Entities\WahanaDevices', 'id', 'wahana_id');
    }

}
