<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use DB;
use DataTables;

use Modules\Item\Http\Requests\ReceivingFormRequest;

use Modules\Item\Entities\ProductItem;
use Modules\Item\Entities\ProductStock;
use Modules\Item\Entities\ProductReceiving;

class ReceivingItemController extends Controller
{
    public function json(Request $request){
        if ($request) {
            $item = ProductItem::query(); 
            $item->with('stock');
            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($item){
                return view('item::content/receiving/action/button',[
                    'item' => $item,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('receivingView');
        }
    }

    public function jsonLog(Request $request){
        if ($request) {
            $item = ProductReceiving::query(); 
            $item->where(['product_id' => $request->id]);
            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('buy_prices',function($item){
                return number_format($item->buy_price);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('receivingView');
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $item = ProductItem::find($request->id);
        if($request){
            $dataTableURL = route('receivingJson',$request->all());
        }else{
            $dataTableURL = route('receivingJson');
        }
        return view('item::content/receiving/view',compact([
            'dataTableURL','item'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $item = ProductItem::with('stock')->find($request->id);
        if($request){
            $dataTableURL = route('receivingJsonLog',$request->all());
        }else{
            $dataTableURL = route('receivingJsonLog');
        }
        return view('item::content/receiving/form',compact([
            'item','dataTableURL'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(ReceivingFormRequest $request)
    {
        DB::beginTransaction();
        try{
            $receive = new ProductReceiving;
            $receive->user_id = Auth::user()->id;
            $receive->product_id = $request->id;
            $receive->quantity = $request->quantity;
            $receive->buy_price = $request->buy_price;
            $receive->enter_date = date('Y-m-d',strtotime($request->enter_date));
            $receive->notes = $receive->notes;
            $receive->save();

            $item = ProductStock::where(['item_id' =>$request->id])->first();
            $item->quantity = $item->quantity + $request->quantity;
            $item->save();
            DB::commit();
            flash('Stok berhasil diperbaharui')->success();
            return redirect()->back();
        }catch(Exception $e){
            DB::rollback();
            flash('Fail')->error();
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('item::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('item::edit');
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
