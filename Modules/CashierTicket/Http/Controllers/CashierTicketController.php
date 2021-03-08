<?php

namespace Modules\CashierTicket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DB;
use Cart;
use PDF;
use Auth;
use Spipu\Html2Pdf\Html2Pdf;

use Modules\CashierTicket\Entities\WahanaDevices;
use Modules\CashierTicket\Entities\Transaction;
use Modules\CashierTicket\Entities\TransactionItem;
use Modules\CashierTicket\Entities\TransactionCart;

use Modules\CashierTicket\Http\Requests\Cashier\AddCartRequest;
use Modules\CashierTicket\Http\Requests\Cashier\CashbackRequest;
use Modules\CashierTicket\Http\Requests\Cashier\PassTicketRequest;
use Modules\CashierTicket\Http\Requests\Cashier\CreateTransactionRequest;
use Modules\CashierTicket\Http\Requests\FilterRequest;


class CashierTicketController extends Controller
{
    public function cashback(CashbackRequest $request){
        Cart::setGlobalDiscount($request->cashback);
        if ($request->type_ticket == 'pass') {
            return redirect()->route('cashTicketView',['type' => 'pass']);
        }else{
            return redirect()->back();
        }
    }

    public function cartPass(AddCartRequest $request){
        $code = $request->code;
        // if (is_array($request->code)) {
            Cart::destroy();
            foreach ($request->code as $key => $item) {
                $item = WahanaDevices::where(['code' => $request->code[$key]])->first();
                Cart::add([
                    'id' => $item->code,
                    'name' => $item->name,
                    'qty' => 1,
                    'price' => $item->rates,
                    'weight' => 0
                ]);
            }
        // }else{
        // }
        // if ($request->ticket_type == 'pass') {
            return redirect()->route('cashTicketView',['type' => 'pass']);
        // }else{
            // return redirect()->route('cashTicketView');
        // }
    }

    public function cartBasic(AddCartRequest $request){
        $item = WahanaDevices::where(['code' => $request->code])->first();
        Cart::add([
            'id' => $item->code,
            'name' => $item->name,
            'qty' => $request->quantity,
            'price' => $item->rates,
            'weight' => 0
        ]);
        return redirect()->route('cashTicketView');
    }
    public function cartUp(AddCartRequest $request){
        $item = WahanaDevices::where(['code' => $request->code])->first();
        Cart::add([
            'id' => $item->code,
            'name' => $item->name,
            'qty' => 1,
            'price' => $item->rates,
            'weight' => 0
        ]);
        return redirect()->route('cashTicketView');
    }

    public function cartRemove(Request $request){
        Cart::remove($request->rowid);
        flash('Item berhasil dikeluarkan dari keranjang')->success();
        if ($request->type == 'pass') {
            return redirect()->route('cashTicketView',['type' => 'pass']);
        }else{
            return  redirect()->route('cashTicketView');
        }
    }

    public function cartStore(CreateTransactionRequest $request){
        if (Cart::count()) {
            if (Cart::subtotal('0','','') <= $request->cash) {
                $getLastTransaction = Transaction::where(DB::Raw('DATE(created_at)'),date('Y-m-d'))->count() + 1;
                $number = date('dmy').'01'.$getLastTransaction;
                DB::beginTransaction();
                try {
                    $transaction = new Transaction;
                    $transaction->transaction_number =  $number;
                    $transaction->user_id = Auth::user()->id;
                    $transaction->payment = 'tunai';
                    $transaction->cash = $request->cash;
                    $transaction->change = $request->cash - Cart::subtotal('0', '', '');
                    $transaction->ticket_type = $request->ticket_type;
                    $transaction->cashback = Cart::discount('0','','');
                    $transaction->save();

                    foreach(Cart::content() as $item):
                        $product = WahanaDevices::where(['code' => $item->id])->first();
                        $transactionItem = new TransactionItem;
                        $transactionItem->transaction_id = $transaction->id;
                        $transactionItem->code = $product->code;
                        $transactionItem->name = $product->name;
                        $transactionItem->price = $product->rates;
                        $transactionItem->save();

                        $transactionCart = new TransactionCart;
                        $transactionCart->transaction_id = $transaction->id;
                        $transactionCart->code = $item->id;
                        $transactionCart->item_id = $transactionItem->id;
                        $transactionCart->quantity = $item->qty;
                        $transactionCart->price = $product->rates;
                        $transactionCart->subtotal = $item->subtotal;
                        $transactionCart->save();
                    endforeach;
                    DB::commit();
                    return redirect()->route('cashTicketSuccess',['number' => $number]);

                } catch (\Exception $e) {
                    DB::rollback();
                    flash('Fail'.$e)->error();
                    return redirect()->route('cashTicketView');
                }
            }else{
                flash('Nominal Pembayaran Tidak Valid')->error();
                return redirect()->route('cashTicketView');
            }


        }else{
            flash('Keranjang masih kosong')->error();
            return redirect()->route('cashTicketView');
        }
    }
    public function cartSuccess(FilterRequest $request){
        $transaction = Transaction::with(['item' => function($query){
                            $query->with('cart')->get();
                        }])
                        ->where(['transaction_number' => $request->number])->first();
        $total = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');

        $beforeCashback = TransactionCart::where(['transaction_id' => $transaction->id])->sum(DB::raw('quantity * price'));

        Cart::destroy();
        return view('cashierticket::contents/cashier/success',compact([
            'transaction','total','beforeCashback'
        ]));
    }
    public function cartReceipt(FilterRequest $request){
        if ($request->ticket) {
            $paper = array(0,0,212.598,282);
            $transaction = Transaction::with(['item' => function($query){
                                $query->with('cart')->get();
                            }])
                            ->where(['transaction_number' => $request->number])->first();
            $checkCart = TransactionCart::where(['transaction_id' => $transaction->id])->count();
            if ($checkCart) {
                $total = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
                $beforeCashback = TransactionCart::where(['transaction_id' => $transaction->id])->sum(DB::raw('quantity * price'));
                if ($transaction->ticket_type == 'pass') {
                    $pdf = PDF::setPaper(['0','0','212.598','20082.6772'], 'portrait')->loadView('cashierticket::contents/cashier/pdf/ticket',compact([
                        'transaction','total','beforeCashback'
                    ]));
                    // $content = view('cashierticket::contents/cashier/pdf/ticket' , compact([
                    //     'transaction','total','beforeCashback'
                    // ]))->render();
                    // $html2pdf = new html2pdf('P' , $paper , 'en') ;
                    // $html2pdf->writeHTML($content);
		            // $html2pdf->output();
                }else{
                    $pdf = PDF::setPaper(['0','0','212.598','282'], 'portrait')->loadView('cashierticket::contents/cashier/pdf/ticket',compact([
                        'transaction','total','beforeCashback'
                    ]));
                    // $content = view('cashierticket::contents/cashier/pdf/ticket' , compact([
                    //     'transaction','total','beforeCashback'
                    // ]))->render();
                    // $html2pdf = new html2pdf('P' , $paper , 'en') ;
                    // $html2pdf->writeHTML($content);
		            // $html2pdf->output();
                }
            }else{
                echo 'Oops Not Found';
            }

            return $pdf->stream();
        }else{
            $transaction = Transaction::with(['item' => function($query){
                                $query->with('cart')->get();
                            },'cart'])
                            ->where(['transaction_number' => $request->number])->first();

            $checkCart = TransactionCart::where(['transaction_id' => $transaction->id])->count();
            if ($checkCart) {
                $total = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
                $beforeCashback = TransactionCart::where(['transaction_id' => $transaction->id])->sum(DB::raw('quantity * price'));
                // $pdf = PDF::setPaper(['0','0','212.598','290'], 'portrait')->loadView('cashierticket::contents/cashier/pdf/receipt',compact([
                //     'transaction','total','beforeCashback'
                // ]));
                return view('cashierticket::contents/cashier/pdf/recipt' ,compact([
                    'transaction','total','beforeCashback'
                ]));
            }else{
                echo 'Opps Not Found';
            }
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $getLastTransaction = Transaction::where(DB::Raw('DATE(created_at)'),date('Y-m-d'))->count() + 1;
        $transaction = date('dmy').'01'.$getLastTransaction;
        $withTimer = WahanaDevices::where(['device_type'=>'With Timer','status' => 'Ready'])->orderBy('name','asc')->get();
        $oneTime = WahanaDevices::where(['device_type'=>'One Time','status' => 'Ready'])->orderBy('name','asc')->get();

        return view('cashierticket::contents/cashier/view',compact([
            'withTimer','oneTime','transaction'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('cashierticket::create');
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
        return view('cashierticket::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('cashierticket::edit');
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
    public function destroy($id)
    {
        //
    }
}
