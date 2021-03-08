<?php

namespace Modules\TransactionTicket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Auth;
use Hash;

use App\User;

use Modules\TransactionTicket\Entities\Transaction;
use Modules\TransactionTicket\Entities\TransactionCart;
use Modules\TransactionTicket\Entities\TransactionRefund;
use Modules\TransactionTicket\Entities\TransactionItem;

use Modules\TransactionTicket\Http\Requests\FilterRequest;
use Modules\TransactionTicket\Http\Requests\RefundRequest;

class RefundController extends Controller
{
    public function authView(){

    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilterRequest $request)
    {
        $transaction = Transaction::where(['transaction_number' => $request->transNum,'user_id' => Auth::user()->id])
                                    ->with(['item' => function($query){
                                        $query->with(['cart']);
                                    }])
                                    ->first();
        $itemInfo = TransactionCart::where(['transaction_id' => $transaction->id,'id' => $request->item])
                                    ->with(['item'])
                                    ->first();

        $storeManager = User::join('role_user','role_user.user_id','=','users.id')
                        ->where(['role_user.role_id' => '5'])
                        ->orderBy('users.name','asc')->get();

        return view('transactionticket::content/refund/view',compact([
            'transaction','itemInfo','storeManager'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transactionitem::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(RefundRequest $request)
    {
        $storeManager = DB::table('users')->where(['email' => $request->store_manager])->first();
        if (Hash::check($request->pin, $storeManager->password)) {
            DB::beginTransaction();
            try {
                /* Transaction */
                $transaction = Transaction::where(['transaction_number' => $request->transaction_number,'user_id' => Auth::user()->id])->first();            
                $itemInfo = TransactionCart::where(['transaction_id' => $transaction->id,'id' => $request->item])
                                        ->with(['item'])
                                        ->first();
                $item = TransactionItem::where(['transaction_id' => $transaction->id,'code' => $itemInfo->item->code])->first();
                
                /* Inventory Process */
                if ($request->quantity <= $itemInfo->quantity) {
                    $qty = $itemInfo->quantity - $request->quantity;
                    if ($qty == 0) {
                        $refundedCart = new TransactionRefund;
                        $refundedCart->transaction_id = $transaction->id;
                        $refundedCart->item_id = $item->id;
                        $refundedCart->quantity = $request->quantity;
                        $refundedCart->price = $item->price;
                        $refundedCart->subtotal = $request->quantity * $item->price;
                        $refundedCart->refunded_by = $storeManager->id;
                        $refundedCart->notes = $request->notes;
                        $refundedCart->save();

                        $transaction->change = $transaction->change + $request->quantity * $item->price;
                        $transaction->save();

                        $itemInfo->delete();
                    }else{
                        $itemInfo->quantity = $itemInfo->quantity - $request->quantity;
                        $itemInfo->subtotal = $item->price * $qty;
                        $itemInfo->save();

                        $refundedCart = new TransactionRefund;
                        $refundedCart->transaction_id = $transaction->id;
                        $refundedCart->item_id = $item->id;
                        $refundedCart->quantity = $request->quantity;
                        $refundedCart->price = $item->price;
                        $refundedCart->subtotal = $request->quantity * $item->price;
                        $refundedCart->refunded_by = $storeManager->id;
                        $refundedCart->notes = $request->notes;
                        $refundedCart->save();

                        $transaction->change = $transaction->change + $request->quantity * $item->price;
                        $transaction->save();
                        
                    }

                    DB::commit();
                    
                    flash('Refund Berhasil, Item '.$itemInfo->item->name.' dengan jumlah item yang di kembalikan x'.$request->quantity)->success();
                    return redirect()->route('transTicketDetail',['number'=> $request->transaction_number]);
                }else{
                    flash('Jumlah Item Tidak Valid !')->warning();
                    return redirect()->route('transTicketDetail',['number'=> $request->transaction_number]);
                }
            } catch (Exception $e) {
                DB::rollback();
                flash($e)->error();
                return redirect()->route('transTicketDetail',['number'=> $request->transaction_number]);
            }
            
                
            
        }else{
            flash('PIN anda salah !')->error();
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('transactionitem::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('transactionitem::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
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
}
