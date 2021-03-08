<?php

namespace Modules\Report\Entities\Item;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__cart';

    public function item()
    {
        return $this->hasOne('Modules\Report\Entities\Item\TransactionItem', 'id', 'item_id');
    }
}
