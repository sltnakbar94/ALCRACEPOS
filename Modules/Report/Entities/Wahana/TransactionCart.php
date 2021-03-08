<?php

namespace Modules\Report\Entities\Wahana;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__cart';

    public function item()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionItem', 'id', 'item_id');
    }
}
