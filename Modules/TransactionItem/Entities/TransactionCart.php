<?php

namespace Modules\TransactionItem\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashitem__cart';

    public function item()
    {
        return $this->hasOne('Modules\TransactionItem\Entities\TransactionItem', 'id', 'item_id');
    }
}
