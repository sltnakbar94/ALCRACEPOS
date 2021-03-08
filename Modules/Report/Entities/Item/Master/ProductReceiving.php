<?php

namespace Modules\Report\Entities\Item\Master;

use Illuminate\Database\Eloquent\Model;

class ProductReceiving extends Model
{
    protected $fillable = [];
    protected $table = 'product__receiving';
    
    public function item()
    {
        return $this->hasOne('Modules\Report\Entities\Item\Master\ProductItem', 'id', 'product_id');
    }
}
