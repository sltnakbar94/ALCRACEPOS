<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Item\Entities\ProductItem;
use Modules\Item\Entities\ProductStock;

use DataTables;
use DB;

class StockController extends Controller
{
    public function json(Request $request){
        if ($request) {
            $stock = ProductItem::with('stock')->select('product__item.*');
            $retrieveJson = DataTables::eloquent($stock);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($stock){
                return view('item::content/stock/action/button',[
                    'stock' => $stock,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('itemView');
        }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if($request){
            $dataTableURL = route('stockJson',$request->all());
        }else{
            $dataTableURL = route('stockJson');
        }
        return view('item::content/stock/view',compact(['dataTableURL']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('item::create');
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
