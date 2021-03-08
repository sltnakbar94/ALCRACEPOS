<?php

namespace Modules\Shift\Entities\TransItem;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__cart';

    public function item()
    {
        return $this->hasOne('Modules\Shift\Entities\TransItem\TransactionItem', 'id', 'item_id');
    }
}
