<?php

namespace Modules\Report\Http\Controllers\ItemSelling;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Report\Entities\Item\Transaction as ItemTransaction;
use Modules\Report\Entities\Item\TransactionCart as ItemTransactionCart;
use Modules\Report\Entities\Item\TransactionItem as ItemTransactionItem;
use Modules\Report\Entities\Item\TransactionRefund as ItemTransactionRefund;
use Modules\Report\Entities\Item\Master\ProductItem;
use Modules\Report\Entities\Item\Master\ProductReceiving;

use DB;
use Auth;
use DataTables;

class SalesProfitController extends Controller
{
    public function itemJson(Request $request){
        if ($request) {
            $item = ItemTransactionCart::query();
            $item->selectRaw('cashitem__cart.price,cashitem__cart.code,SUM(cashitem__cart.subtotal) as aggregate');
            $item->selectRaw('SUM(cashitem__cart.quantity) as qty_aggregate');
            $item->groupBy('cashitem__cart.code');
            $item->orderBy('aggregate','desc');

            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            
            $retrieveJson->addColumn('name',function($item){
                return ItemTransactionItem::where('code',$item->code)->first()->name;
            });
            $retrieveJson->addColumn('aggregate',function($item){
                if ($item->aggregate) {
                    return number_format($item->aggregate);
                }else{
                    return '0';
                }
            });
            $retrieveJson->addColumn('buy_price',function($item){
                $check = ProductReceiving::with(['item' => function($query) use($item){
                    $query->where('code',$item->code);
                }])->orderBy('id','desc')->first();

                if ($check->item == null) {
                    return 'Belum tersedia';
                }else{
                    return $check->buy_price;
                }
            });

            $retrieveJson->addColumn('qty_aggregate',function($item){
                if ($item->qty_aggregate) {
                    return number_format($item->qty_aggregate);
                }else{
                    return '0';
                }
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('reportBestSellingWahana');
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $dataTableURL = route('reportProfitItemJson',$request->only(['from','to','staff']));
        }else{
            $dataTableURL = route('reportProfitItemJson');
        }
        return view('report::content/item_selling/view',compact([
            'dataTableURL'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('report::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('report::edit');
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
