<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Item\Http\Requests\ItemFormRequest;
use Modules\Item\Http\Requests\FilteringRequest;

use DataTables;
use DB;
use PDF;
use DNS1D;
use Auth;

use Modules\Item\Entities\ProductCategory;
use Modules\Item\Entities\ProductItem;
use Modules\Item\Entities\ProductStock;
use Modules\Item\Entities\ProductReceiving;
use Modules\Item\Entities\ProductChangePrice;

class ItemController extends Controller
{
    public function generateCode(){
        $product = ProductItem::orderBy('id','desc')->first();
        if ($product) {
            $count = $product->id + 1;
        }else{
            $count = 1;
        }
        $randomNumber = '8'.mt_rand(100000, 999999).$count; 
        return redirect()->route('itemCreate',['generateUniq' => $randomNumber]);
    }

    public function json(FilteringRequest $request){
        if ($request->ajax()) {
            $item = ProductItem::query(); 
            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($item){
                return view('item::content/item/action/button',[
                    'item' => $item,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('itemView');
        }
    }

    public function barcode(FilteringRequest $request){
        $item = ProductItem::where(['id' => $request->id])->first();
        if ($item) {
            $barcode =  DNS1D::getBarcodePNG($item->code, "C128",1.3,43);
            // return view('item::content.item.pdf.barcode',compact('item','barcode'));
            $pdf = PDF::setPaper(['0','0','80.732','164.409'], 'landscape')->loadView('item::content.item.pdf.barcode',compact('item','barcode'));
            return $pdf->stream();
        }else{
            echo 'PDF Undefined';
        }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilteringRequest $request)
    {
        if($request){
            $dataTableURL = route('itemJson',$request->all());
        }else{
            $dataTableURL = route('itemJson');
        }
        return view('item::content/item/view',compact([
            'dataTableURL'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('item::content/item/create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(ItemFormRequest $request)
    {
        $product = ProductItem::onlyTrashed()->where(['code' => $request->code])->first();
        DB::beginTransaction();
        try {
            if ($product) {
                $restoreItem = ProductItem::onlyTrashed()->find($product->id)->restore();
                $restoreStock = ProductStock::onlyTrashed()->where(['item_id' => $product->id])->restore();
                
                $item = ProductItem::firstOrNew(['code' => $request->code]);
                $item->category_id = $request->category ?? null;
                $item->code = $request->code;
                $item->name = $request->item;
                $item->price = $request->price;
                $item->status = $request->status;
                $item->deleted_at = NULL;
                $item->save();
    
                $stock = ProductStock::firstOrNew(['id' => $item->id]);
                $stock->item_id = $item->id;
                $stock->quantity = $request->stock;
                $stock->save();
            }else{
                $checkCode = ProductItem::where(['code' => $request->code])->first();
                if ($checkCode) {
                    flash('Code sudah terpakai')->error();
                    return redirect()->back()->withInput();
                }else{

                    $item = new ProductItem;
                    $item->category_id = $request->category ?? null;
                    $item->code = $request->code;
                    $item->name = $request->item;
                    $item->price = $request->price;
                    $item->status = $request->status;
                    $item->save();
                    
                    $stock = new ProductStock;
                    $stock->item_id = $item->id;
                    $stock->quantity = $request->stock;
                    $stock->save();
                }
            }
            DB::commit();
            
            flash('Berhasil Disimpan')->success();
            return redirect()->route('itemCreate');
            
        } catch (Exception $e) {
            
            DB::rollback();
            flash('Oops somthing wrong',$e)->error();
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
    public function edit(Request $request)
    {
        $item = ProductItem::find($request->id);

        if ($item == false) {
            return redirect()->route('itemView');
        }
        return view('item::content/item/edit',compact([
            'item'
        ]));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(ItemFormRequest $request)
    {
        $item = ProductItem::find($request->id);
        $item->category_id = $request->category ?? null;
        $item->name = $request->item;
        if (Auth::user()->hasRole('superadminsitrator')) {
            $item->price = $request->price;
        }
        $item->status = $request->status;
        $item->save();

        flash('Berhasil Diperbaharui')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            $item = ProductItem::find($request->id);
            if ($item == false) {
                return redirect()->route('itemView');
            }
            $stock = ProductStock::where(['item_id' => $request->id])->first();

            $receiving = ProductReceiving::where(['product_id' => $request->id])->delete();
            $changePrice = ProductChangePrice::where(['product_id' => $request->id])->delete();
            
            $item->delete();
            $stock->delete();
            
            DB::commit();
            
            flash('Berhasil Dihapus')->success();
            return redirect()->back();
            
        } catch (Exception $e) {
            
            DB::rollback();
            flash('Oops somthing wrong',$e)->error();
            return redirect()->back();
            
        }
        
        
        
    }
}
