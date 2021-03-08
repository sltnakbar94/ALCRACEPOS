<?php

namespace Modules\Report\Entities\Item;

use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__refund';
    public function item()
    {
        return $this->hasOne('Modules\Report\Entities\Item\TransactionItem', 'id', 'item_id');
    }
}
