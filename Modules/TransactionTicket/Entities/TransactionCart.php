<?php

namespace Modules\TransactionTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashticket__cart';

    public function item()
    {
        return $this->hasOne('Modules\TransactionTicket\Entities\TransactionItem', 'id', 'item_id');
    }
}
