<?php

namespace Modules\Report\Entities\Item;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__item';

    public function cart()
    {
        return $this->hasOne('Modules\Report\Entities\Item\TransactionCart', 'item_id', 'id');
    }
    
    public function cartSum()
    {
        return $this->hasOne('Modules\Report\Entities\Item\TransactionCart', 'code', 'code')
                    ->selectRaw('SUM(quantity) as aggregate,code')
                    ->groupBy('code');
    }
    
}
