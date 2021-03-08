<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BestCounterController extends Controller
{
    public function json(){
        if ($request) {
            $wahana = TransactionItem::query(); 
            $wahana->selectRaw('cashticket__item.*,SUM(cashticket__cart.quantity) as aggregate');
            $wahana->join('cashticket__cart', 'cashticket__item.code', '=', 'cashticket__cart.code');
            $wahana->groupBy('cashticket__cart.code');
            $wahana->orderBy('aggregate','desc');
        
            $retrieveJson = DataTables::eloquent($wahana);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($wahana){
                return '<a href="" class="btn btn-secondary btn-sm">Rincian <i class="fa fa-angle-double-right"></i></a>';
            });
            $retrieveJson->addColumn('aggregate',function($wahana){
                if ($wahana->cartSum) {
                    return number_format($wahana->cartSum->aggregate);
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
