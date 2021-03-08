<?php

namespace Modules\Shift\Entities\TransTicket;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__cart';

    public function item()
    {
        return $this->hasOne('Modules\Shift\Entities\TransTicket\TransactionItem', 'id', 'item_id');
    }
}
