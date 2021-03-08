<?php

namespace Modules\Shift\Entities\TransTicket;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__item';

    public function cart()
    {
        return $this->hasOne('Modules\Shift\Entities\TransTicket\TransactionCart', 'item_id', 'id');
    }
}
