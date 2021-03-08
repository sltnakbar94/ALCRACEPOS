<?php

namespace Modules\TransactionTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashticket__item';

    public function cart()
    {
        return $this->hasOne('Modules\TransactionTicket\Entities\TransactionCart', 'item_id', 'id');
    }
}
