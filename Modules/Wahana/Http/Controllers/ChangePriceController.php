<?php

namespace Modules\Wahana\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Item\Http\Requests\FilteringRequest;

use DataTables;
use DB;
use Auth;

use Modules\Wahana\Entities\WahanaDevices;
use Modules\Wahana\Entities\WahanaChangePrice;

class ChangePriceController extends Controller
{
    public function json(FilteringRequest $request){
        if ($request) {
            $item = WahanaDevices::query(); 
            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($item){
                return view('wahana::content/changeprice/action/button',[
                    'item' => $item,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('wahanaView');
        }
    }

    public function jsonRequested(Request $request){
        if ($request) {
            $item = WahanaChangePrice::query();
            $item->where(['wahana_id' => $request->id]);
            $retrieveJson = DataTables::eloquent($item);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('statusRaw',function($item){
                if ($item->status == 'Not Approved') {
                    return $item->status.'<a href="javascript:;" data-toggle="modal" data-target="#myModalReason'.$item->id.'" > <i class="fa fa-question"></i></a> 
                    <div id="myModalReason'.$item->id.'" class="modal fade">
                        <div class="modal-dialog modal-lg" style="width:100%" role="document">
                                <div class="modal-content tx-size-sm">
                                <div class="modal-header pd-x-20">
                                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Alasan Penolakan</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body pd-20">
                                    <span>'.$item->reason.'</span>
                                </div><!-- modal-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div>
                    ';
                }else{
                    return $item->status;
                }
            });
            $retrieveJson->addColumn('prices',function($item){
                return number_format($item->previous_price).' => '.number_format($item->price);
            });
            $retrieveJson->rawColumns(['statusRaw']);
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('itemView');
        }
    }

    public function request(Request $request){
        $item = WahanaDevices::find($request->id);
        if($request){
            $dataTableURL = route('changePriceWhRequestedJson',$request->all());
        }else{
            $dataTableURL = route('changePriceWhRequestedJson');
        }
        return view('wahana::content/changeprice/form',compact([
            'dataTableURL','item'
        ]));
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilteringRequest $request)
    {
        if($request){
            $dataTableURL = route('changePriceWhJson',$request->all());
        }else{
            $dataTableURL = route('changePriceWhJson');
        }
        return view('wahana::content/changeprice/view',compact([
            'dataTableURL'
        ]));
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
        $item = WahanaDevices::find($request->id);

        $changePrice = new WahanaChangePrice;
        $changePrice->user_id = Auth::user()->id;
        $changePrice->wahana_id = $request->id;
        $changePrice->previous_price = $item->rates;
        $changePrice->price = $request->price;
        $changePrice->notes = $request->notes;
        $changePrice->status = 'Waiting Approval';
        $changePrice->updated_at = null;
        $changePrice->save();

        flash('Perubahan sedang diajukan mohon tunggu proses persetujuan Admin Pusat')->success();
        return redirect()->back();
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
