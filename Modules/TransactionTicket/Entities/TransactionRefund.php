<?php

namespace Modules\TransactionTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionRefund extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashticket__refund';
    public function item()
    {
        return $this->hasOne('Modules\TransactionTicket\Entities\TransactionItem', 'id', 'item_id');
    }
}
