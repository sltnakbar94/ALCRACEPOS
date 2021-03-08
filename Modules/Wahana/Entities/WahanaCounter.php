<?php

namespace Modules\Wahana\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WahanaCounter extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    protected $table = 'wahana__counter';
}
