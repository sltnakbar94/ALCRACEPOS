<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductReceiving extends Model
{
    protected $fillable = [];
    protected $table = 'product__receiving';
    
    public function item()
    {
        return $this->hasOne('Modules\Item\Entities\ProductItem', 'id', 'product_id');
    }
}
