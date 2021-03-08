<?php

namespace Modules\CashierTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__item';

    public function cart()
    {
        return $this->hasOne('Modules\CashierTicket\Entities\TransactionCart', 'item_id', 'id');
    }
}
