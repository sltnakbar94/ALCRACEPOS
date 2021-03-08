<?php

namespace Modules\CashierItem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Cart;
use PDF;
use Auth;

use Modules\CashierItem\Entities\ProductItem;
use Modules\CashierItem\Entities\ProductStock;
use Modules\CashierItem\Entities\Transaction;
use Modules\CashierItem\Entities\TransactionItem;
use Modules\CashierItem\Entities\TransactionCart;

use Modules\CashierItem\Http\Requests\FilterRequest;
use Modules\CashierItem\Http\Requests\Cashier\AddCartRequest;
use Modules\CashierItem\Http\Requests\Cashier\UpdateCartRequest;
use Modules\CashierItem\Http\Requests\Cashier\CreateTransactionRequest;

class CashierItemController extends Controller
{
    public function json(Request $request){
        if ($request->has('q')) {
            $param = $request->q;
            $item = ProductItem::where('code','LIKE','%'.$param.'%')->get();
            return response()->json($item, 200);
        }
    }

    public function cart(AddCartRequest $request){
        $item = ProductItem::where(['code' => $request->code,'status' => 'publish'])->first();
        if ($item) {
            Cart::add([
                'id' => $item->code, 
                'name' => $item->name, 
                'qty' => $request->quantity, 
                'price' => $item->price, 
                'weight' => 0
            ]);
            // return response()->json(Cart::content(), 200);
            return redirect()->back();
        }else{
            flash('Barang tidak tersedia')->error();
            return redirect()->back();
        }
    }
    public function cartUpdate(UpdateCartRequest $request){
        foreach($request->input('rowid') as $key => $condition):
            Cart::update($request->input('rowid')[$key], $request->input('quantity')[$key]);
        endforeach;
        return redirect()->back();
    }

    public function cartUp(UpdateCartRequest $request){
        $cart = Cart::get($request->rowid);
        $up = $cart->qty + 1;
        Cart::update($request->rowid, $up);
        return redirect()->back();
    }

    public function cartDown(UpdateCartRequest $request){
        $cart = Cart::get($request->rowid);
        $up = $cart->qty - 1;
        Cart::update($request->rowid, $up);
        return redirect()->back();
    }
    
    public function cartRemove(Request $request){
        Cart::remove($request->rowid);
        flash('Item berhasil dikeluarkan dari keranjang')->success();
        return redirect()->back();
    }

    public function cartStore(CreateTransactionRequest $request){
        if (Cart::count()) {
            if (Cart::subtotal('0','','') <= $request->cash) {
                $getLastTransaction = Transaction::where(DB::Raw('DATE(created_at)'),date('Y-m-d'))->count() + 1;
                $number = date('dmy').'00'.$getLastTransaction;
                DB::beginTransaction();
                try {
                    $transaction = new Transaction;
                    $transaction->transaction_number =  $number;
                    $transaction->user_id = Auth::user()->id;
                    $transaction->payment = 'tunai';
                    $transaction->cash = $request->cash;
                    $transaction->change = $request->cash - Cart::subtotal('0', '', '');
                    $transaction->save();

                    foreach(Cart::content() as $item):
                        $product = ProductItem::where(['code' => $item->id])->first();
                        $transactionItem = new TransactionItem;
                        $transactionItem->transaction_id = $transaction->id;
                        $transactionItem->code = $product->code;
                        $transactionItem->name = $product->name;
                        $transactionItem->price = $product->price;
                        $transactionItem->save();

                        $reduceStock = ProductStock::where(['item_id' => $product->id])->first();
                        // echo $transactionItem->id;
                        $currentStock = $reduceStock->quantity - $item->qty;
                        $reduceStock->quantity = $currentStock;
                        $reduceStock->save();

                        $transactionCart = new TransactionCart;
                        $transactionCart->transaction_id = $transaction->id;
                        $transactionCart->code = $item->id;
                        $transactionCart->item_id = $transactionItem->id;
                        $transactionCart->quantity = $item->qty;
                        $transactionCart->price = $product->price;
                        $transactionCart->subtotal = $item->subtotal;
                        $transactionCart->save();
                    endforeach;
                    // DB::rollback();
                    // return redirect()->route('cashItemView');
                    DB::commit();
                    return redirect()->route('cashItemSuccess',['number' => $number]);
                    
                } catch (\Exception $e) {
                    DB::rollback();
                    // return $e;
                    flash('Fail')->error();
                    return redirect()->route('cashItemView');
                }
            }else{
                flash('Nominal Pembayaran Tidak Valid')->error();
                return redirect()->route('cashItemView');
            }
        }else{
            flash('Keranjang masih kosong')->error();
            return redirect()->route('cashItemView');
        }
        // return response()->json($request, 200);
    }

    public function cartReceipt(FilterRequest $request){
        $transaction = Transaction::with(['item' => function($query){
                            $query->with('cart')->get();
                        }])
                        ->where(['transaction_number' => $request->number])->first();
        // return response()->json($transaction, 200);
        $checkCart = TransactionCart::where(['transaction_id' => $transaction->id])->count();
        if ($checkCart) {
            $total = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
            $pdf = PDF::setPaper(['0','0','212.598','20082.6772'], 'portrait')->loadView('cashieritem::contents/cashier/pdf/receipt',compact([
                'transaction','total'
            ]));
            return $pdf->stream();
        }else{
            echo 'Oops Not Found';
        }
    }

    public function cartSuccess(FilterRequest $request){
        $transaction = Transaction::with(['item' => function($query){
                            $query->with('cart')->get();
                        }])
                        ->where(['transaction_number' => $request->number])->first();
        $total = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
        Cart::destroy();
        return view('cashieritem::contents/cashier/success',compact([
            'transaction','total'
        ]));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $getLastTransaction = Transaction::where(DB::Raw('DATE(created_at)'),date('Y-m-d'))->count() + 1;
        $transaction = date('dmy').'00'.$getLastTransaction;
        return view('cashieritem::contents/cashier/view',compact([
            'transaction'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('cashieritem::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('cashieritem::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('cashieritem::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {

    }
}
