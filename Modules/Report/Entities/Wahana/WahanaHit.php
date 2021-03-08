<?php

namespace Modules\Report\Entities\Wahana;

use Illuminate\Database\Eloquent\Model;

class WahanaHit extends Model
{
    protected $fillable = ['counter_id'];
    protected $table = 'wahana__hit';
}
