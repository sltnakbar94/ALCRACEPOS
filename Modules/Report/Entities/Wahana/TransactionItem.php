<?php

namespace Modules\Report\Entities\Wahana;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__item';

    public function transaction()
    {
        return $this->hasOne('Transaction', 'id', 'transaction_id');
    }
    public function cart()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionCart', 'item_id', 'id');
    }
    public function cartSum()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionCart', 'code', 'code')
                    ->selectRaw('SUM(quantity) as aggregate,code')
                    ->groupBy('code');
    }
}
