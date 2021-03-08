<?php

namespace Modules\Shift\Entities\TransTicket;

use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__refund';
    public function item()
    {
        return $this->hasOne('Modules\Shift\Entities\TransTicket\TransactionItem', 'id', 'item_id');
    }
}
