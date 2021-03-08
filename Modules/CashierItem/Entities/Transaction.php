<?php

namespace Modules\CashierItem\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__transaction';

    public function item()
    {
        return $this->hasMany('Modules\CashierItem\Entities\TransactionItem', 'transaction_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany('Modules\CashierItem\Entities\TransactionCart', 'transaction_id', 'id');
    }
}
