<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use Auth;
use DB;

use Modules\Report\Entities\Wahana\Transaction;
use Modules\Report\Entities\Wahana\TransactionCart;
use Modules\Report\Entities\Wahana\TransactionItem;
use Modules\Report\Entities\Wahana\TransactionRefund;

use Modules\Report\Entities\Item\Transaction as ItemTransaction;
use Modules\Report\Entities\Item\TransactionCart as ItemTransactionCart;
use Modules\Report\Entities\Item\TransactionItem as ItemTransactionItem;
use Modules\Report\Entities\Item\TransactionRefund as ItemTransactionRefund;

class BestSellingController extends Controller
{
    public function wahanaJson(Request $request){
        // if ($request) {
            $wahana = TransactionCart::query();
            $wahana->selectRaw('cashticket__cart.code,SUM(cashticket__cart.quantity) as aggregate');
            $wahana->groupBy('cashticket__cart.code');
            $wahana->orderBy('aggregate','desc');
        
            // return response()->json($wahana, 200);
            
            $retrieveJson = DataTables::eloquent($wahana);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($wahana){
                return '<a href="" class="btn btn-secondary btn-sm">Rincian <i class="fa fa-angle-double-right"></i></a>';
            });
            $retrieveJson->addColumn('name',function($wahana){
                return TransactionItem::where('code',$wahana->code)->first()->name;
            });
            $retrieveJson->addColumn('aggregate',function($wahana){
                if ($wahana->aggregate) {
                    return number_format($wahana->aggregate);
                }else{
                    return '0';
                }
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        // }else{
        //     return redirect()->route('reportBestSellingWahana');
        // }
    }
    
    public function wahana(Request $request){
        if ($request) {
            $dataTableURL = route('reportBestSellingWahanaJson',$request->only(['from','to','staff']));
        }else{
            $dataTableURL = route('reportBestSellingWahanaJson');
        }
        return view('report::content/best_selling/wahana/view',compact([
            'dataTableURL'
        ]));
    }

    public function itemJson(Request $request){
        if ($request) {
            $item = ItemTransactionCart::query();
            $item->selectRaw('cashitem__cart.code,SUM(cashitem__cart.quantity) as aggregate');
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
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('reportBestSellingWahana');
        }
    }

    public function item(Request $request){
        if ($request) {
            $dataTableURL = route('reportBestSellingItemJson',$request->only(['from','to','staff']));
        }else{
            $dataTableURL = route('reportBestSellingItemJson');
        }
        return view('report::content/best_selling/item/view',compact([
            'dataTableURL'
        ]));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('report::index');
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
