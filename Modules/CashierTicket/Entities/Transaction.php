<?php

namespace Modules\CashierTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__transaction';

    public function item()
    {
        return $this->hasMany('Modules\CashierTicket\Entities\TransactionItem', 'transaction_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany('Modules\CashierTicket\Entities\TransactionCart', 'transaction_id', 'id');
    }
    
}
