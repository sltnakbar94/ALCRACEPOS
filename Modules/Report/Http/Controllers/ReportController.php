<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use DataTables;

// Item
use Modules\Report\Entities\Item\ProductItem;
use Modules\Report\Entities\Item\ProductStock;
use Modules\Report\Entities\Item\Transaction as TransItem;
use Modules\Report\Entities\Item\TransactionCart as TransItemCart;
use Modules\Report\Entities\Item\TransactionItem as TransItemItem;
use Modules\Report\Entities\Item\TransactionRefund as TransItemRefund;

// Wahana 
use Modules\Report\Entities\Wahana\Transaction as TransTicket;
use Modules\Report\Entities\Wahana\TransactionCart as TransTicketCart;
use Modules\Report\Entities\Wahana\TransactionItem as TransTicketItem;
use Modules\Report\Entities\Wahana\TransactionRefund as TransTicketRefund;

class ReportController extends Controller
{
    public function jsonTicket(Request $request){
        if($request){
            
        }else{

        }
    }
    
    public function jsonItem(Request $request){
        if($request){
            
        }else{
            
        }
    }

    public function ticket(){

    }

    public function item(){
        
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
        return view('report::content/best_selling/view');
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
