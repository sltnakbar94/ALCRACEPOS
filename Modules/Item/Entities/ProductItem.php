<?php

namespace Modules\Item\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['code'];
    protected $table = 'product__item';

    public function category()
    {
        return $this->hasOne('Modules\Item\Entities\ProductCategory', 'item_id', 'id');
    }
    
    public function stock()
    {
        return $this->hasOne('Modules\Item\Entities\ProductStock', 'item_id', 'id');
    }
    
}
