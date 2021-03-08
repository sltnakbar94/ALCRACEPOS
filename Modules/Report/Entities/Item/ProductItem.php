<?php

namespace Modules\Report\Entities\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    protected $table = 'product__item';
    
    public function stock()
    {
        return $this->hasOne('Modules\Report\Entities\Item\ProductStock', 'item_id', 'id');
    }
    
}
