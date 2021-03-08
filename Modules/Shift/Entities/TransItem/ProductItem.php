<?php

namespace Modules\Shift\Entities\TransItem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    protected $table = 'product__item';
    
    public function stock()
    {
        return $this->hasOne('Modules\Shift\Entities\TransItem\ProductStock', 'item_id', 'id');
    }
    
}
