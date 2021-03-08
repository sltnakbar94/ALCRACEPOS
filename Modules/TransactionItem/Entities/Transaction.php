<?php

namespace Modules\TransactionItem\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['id'];
    protected $table = 'cashitem__transaction';

    public function cartSum()
    {
        return $this->hasOne('Modules\TransactionItem\Entities\TransactionCart', 'transaction_id', 'id')
                    ->selectRaw('SUM(subtotal) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }

    public function itemSum()
    {
        return $this->hasOne('Modules\TransactionItem\Entities\TransactionCart', 'transaction_id', 'id')
                    ->selectRaw('SUM(quantity) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }

    public function refundedSum()
    {
        return $this->hasOne('Modules\TransactionItem\Entities\TransactionRefund', 'transaction_id', 'id')
                    ->selectRaw('SUM(subtotal) as aggregate,transaction_id')
                    ->groupBy('transaction_id');
    }

    public function item()
    {
        return $this->hasMany('Modules\TransactionItem\Entities\TransactionItem', 'transaction_id', 'id');
    }
    public function cart()
    {
        return $this->hasMany('Modules\TransactionItem\Entities\TransactionCart', 'transaction_id', 'id');
    }

    public function refund()
    {
        return $this->hasMany('Modules\TransactionItem\Entities\TransactionRefund', 'transaction_id', 'id');
    }
    public function user()
    {
        // return $this->hasOne('App\User', 'id', 'user_id');
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
    
}
