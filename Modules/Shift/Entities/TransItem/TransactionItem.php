<?php

namespace Modules\Shift\Entities\TransItem;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashitem__item';

    public function cart()
    {
        return $this->hasOne('Modules\Shift\Entities\TransItem\TransactionCart', 'item_id', 'id');
    }
}
