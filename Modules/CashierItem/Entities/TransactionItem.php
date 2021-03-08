<?php

namespace Modules\CashierItem\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__item';

    public function cart()
    {
        return $this->hasOne('Modules\CashierItem\Entities\TransactionCart', 'item_id', 'id');
    }
}
