<?php

namespace Modules\CashierTicket\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WahanaDevices extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'wahana__devices';
}
