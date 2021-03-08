<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductChangePrice extends Model
{
    protected $fillable = [];
    protected $table = 'product__changeprice';

    public function item()
    {
        return $this->hasOne('Modules\Item\Entities\ProductItem', 'id', 'product_id');
    }

}
