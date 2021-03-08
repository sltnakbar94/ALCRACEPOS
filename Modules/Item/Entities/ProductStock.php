<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;
    protected $fillable = ['id'];
    protected $table = 'product__stock';
}
