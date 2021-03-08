<?php

namespace Modules\TransactionItem\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashitem__item';

    public function cart()
    {
        return $this->hasOne('Modules\TransactionItem\Entities\TransactionCart', 'item_id', 'id');
    }
}
