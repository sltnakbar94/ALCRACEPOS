<?php

namespace Modules\Shift\Entities\TransItem;

use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__refund';
    public function item()
    {
        return $this->hasOne('Modules\Shift\Entities\TransItem\TransactionItem', 'id', 'item_id');
    }
}
