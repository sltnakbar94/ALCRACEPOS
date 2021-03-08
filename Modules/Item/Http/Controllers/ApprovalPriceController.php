<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Auth;

use Modules\Item\Entities\ProductItem;
use Modules\Item\Entities\ProductChangePrice;

class ApprovalPriceController extends Controller
{
    public function json(Request $request){
        if ($request) {
            $itemRequested = ProductChangePrice::with(['item']);
            // return response()->json($itemRequested, 200);
            $retrieveJson = DataTables::eloquent($itemRequested);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('codes',function($itemRequested){
                return $itemRequested->item->code;
            });
            $retrieveJson->addColumn('names',function($itemRequested){
                return $itemRequested->item->name;
            });
            $retrieveJson->addColumn('prices',function($itemRequested){
                return number_format($itemRequested->previous_price).' => '.number_format($itemRequested->price);
            });
            $retrieveJson->addColumn('action',function($itemRequested){
                return view('item::content/approvalprice/action/button',[
                    'item' => $itemRequested,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if($request){
            $dataTableURL = route('approvalItemJson',$request->all());
        }else{
            $dataTableURL = route('approvalItemJson');
        }
        return view('item::content/approvalprice/view',compact([
            'dataTableURL'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('item::content/approvalprice/response');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $item = ProductChangePrice::where(['id' => $request->id])->with(['item'])->first();
        if ($item->updated_at) {
            return redirect()->route('approvalItemView');
        }else{
            $item->status = $request->status;
            $item->reason = $request->reason ?? NULL;
            $item->processed_by = Auth::user()->id;
            $item->save();

            if ($request->status == 'Approved') {
                $updateItem = ProductItem::find($item->product_id);
                $updateItem->price = $item->price;
                $updateItem->save();
            }

            flash('Permintaan sudah diresponse');
            return redirect()->route('approvalItemView');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        $item = ProductChangePrice::where(['id' => $request->id])->with(['item'])->first();
        if ($item->updated_at) {
            return redirect()->route('approvalItemView');
        }else{
            return view('item::content/approvalprice/response',compact([
                'item'
            ]));
        }
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
