<?php

namespace Modules\Report\Entities\Wahana;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [];
    protected $table = 'cashticket__transaction';

    public function cartSum()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionCart', 'transaction_id', 'id')
                    ->selectRaw('SUM(subtotal) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }

    public function itemSum()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionCart', 'transaction_id', 'id')
                    ->selectRaw('SUM(quantity) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }
    
    public function refundedSum()
    {
        return $this->hasOne('Modules\Report\Entities\Wahana\TransactionRefund', 'transaction_id', 'id')
                    ->selectRaw('SUM(subtotal) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }

    public function item()
    {
        return $this->hasMany('Modules\Report\Entities\Wahana\TransactionItem', 'transaction_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany('Modules\Report\Entities\Wahana\TransactionCart', 'transaction_id', 'id');
    }
    public function refund()
    {
        return $this->hasMany('Modules\Report\Entities\Wahana\TransactionRefund', 'transaction_id', 'id');
    }
    
}
