<?php

namespace Modules\CounterRace\Entities;

use Illuminate\Database\Eloquent\Model;

class WahanaHit extends Model
{
    protected $fillable = ['counter_id'];
    protected $table = 'wahana__hit';
}
