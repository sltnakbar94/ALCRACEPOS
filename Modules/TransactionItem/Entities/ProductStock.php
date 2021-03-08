<?php

namespace Modules\TransactionItem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    protected $table = 'product__stock';
}
