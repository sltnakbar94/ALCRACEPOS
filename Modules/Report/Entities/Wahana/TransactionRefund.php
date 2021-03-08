<?php

namespace Modules\Report\Entities\Wahana;

use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__refund';
    public function item()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionItem', 'id', 'item_id');
    }
}
