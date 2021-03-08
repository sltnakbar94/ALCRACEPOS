<?php

namespace Modules\TransactionTicket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\TransactionTicket\Entities\Transaction;
use Modules\TransactionTicket\Entities\TransactionCart;
use Modules\TransactionTicket\Entities\TransactionRefund;
use Modules\TransactionTicket\Entities\TransactionItem;
class APIController extends Controller

{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('transactionticket::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transactionticket::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function storeTransaction(Request $request)
    {
        // $transaction = new Transaction;
        $transaction = Transaction::firstOrNew([
            'id' => $request->id,
            'transaction_number' => $request->transaction_number
        ]);
        $transaction->id = $request->id;
        $transaction->shift_id = $request->shift_id;
        $transaction->transaction_number = $request->transaction_number;
        $transaction->user_id = $request->user_id;
        $transaction->payment = $request->payment;
        $transaction->cash = $request->cash;
        $transaction->change = $request->change;
        $transaction->ticket_type = $request->ticket_type;
        $transaction->cashback = $request->cashback;
        $transaction->created_at = $request->created_at;
        $transaction->updated_at = $request->updated_at;
        $transaction->save();
    }

    public function storeItem(Request $request){
        $item = TransactionItem::firstOrNew([
            'id' => $request->id,
        ]);
        $item->id = $request->id;
        $item->transaction_id = $request->transaction_id;
        $item->code = $request->code;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->created_at = $request->created_at;
        $item->updated_at = $request->updated_at;
        $item->save();
    }

    public function storeCart(Request $request){
        $cart = TransactionCart::firstOrNew([
            'id' => $request->id,
        ]);
        $cart->id = $request->id;
        $cart->transaction_id = $request->transaction_id;
        $cart->code = $request->code;
        $cart->item_id = $request->item_id;
        $cart->quantity = $request->quantity;
        $cart->price = $request->price;
        $cart->disc = $request->disc;
        $cart->subtotal = $request->subtotal;
        $cart->created_at = $request->created_at;
        $cart->updated_at = $request->updated_at;
        $cart->save();
    }

    public function storeRefund(Request $request){
        $refund = TransactionRefund::firstOrNew([
            'id' => $request->id,
            'transaction_id' => $request->transaction_id,
            'item_id' => $request->item_id
        ]);
        $refund->id = $request->id;
        $refund->transaction_id = $request->transaction_id;
        $refund->item_id = $request->item_id;
        $refund->quantity = $request->quantity;
        $refund->price = $request->price;
        $refund->subtotal = $request->subtotal;
        $refund->disc = $request->disc;
        $refund->notes = $request->notes;
        $refund->refunded_by = $request->refunded_by;
        $refund->created_at = $request->created_at;
        $refund->updated_at = $request->updated_at;
        $refund->save();
    }
    
    

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('transactionticket::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('transactionticket::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    
    public function updateChangeTransaction(Request $request){
        $transaction = Transaction::find($request->id);
        $transaction->change = $request->change;
        $transaction->updated_at = $request->updated_at;
        $transaction->save();
    }
    public function updateCart(Request $request){
        $cart = TransactionCart::find($request->id);
        $cart->quantity = $request->quantity ?? $cart->quantity;
        $cart->subtotal = $request->subtotal ?? $cart->subtotal;
        $cart->updated_at = $request->updated_at ?? $cart->updated_at;
        $cart->save();
    }

    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function destroyCart($id){
        $cart = TransactionCart::find($id);
        $cart->delete();
    }
}
