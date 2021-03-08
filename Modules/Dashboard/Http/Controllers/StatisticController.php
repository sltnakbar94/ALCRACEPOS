<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\TransactionTicket\Entities\Transaction as Ticket;
use Modules\TransactionTicket\Entities\TransactionCart as TicketCart;
use Modules\TransactionTicket\Entities\TransactionRefund as TicketRefund;
use Modules\TransactionTicket\Entities\TransactionItem as TicketItem;

use Modules\TransactionItem\Entities\Transaction as Item;
use Modules\TransactionItem\Entities\TransactionCart as ItemCart;
use Modules\TransactionItem\Entities\TransactionRefund as ItemRefund;
use Modules\TransactionItem\Entities\TransactionItem as ItemItem;

use DB;

class StatisticController extends Controller
{
    public static function getYears(){
        $legends = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $lastMonth = 12 - date('m');
        $legendSelected = array_slice($legends,0,date('m'));
        $series[0]['name'] = 'Pendapatan Tiket Wahana';
        // $series[1]['name'] = 'Pendapatan Corner';

        foreach($legendSelected as $key => $item){
            $i = $key + 1;
            $series[0]['data'][] = (int)Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                        ->whereMonth('cashticket__cart.created_at' ,$i)
                        ->whereYear('cashticket__cart.created_at' ,date('Y'))
                        ->sum('cashticket__cart.subtotal');

            // $series[1]['data'][] = (int)Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
            //                 ->whereMonth('cashitem__transaction.created_at',$i)
            //                 ->whereYear('cashitem__transaction.created_at',date('Y'))
            //                 ->sum('cashitem__cart.subtotal');
        }
        // dd($legendSelected, $series);
        return ['legend' => $legendSelected, 'series' => $series];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // return response()->json($this->getYears(), 200);
        $yearly = $this->getYears();
        return view('dashboard::content/dashboard/statistic',compact([
            'yearly'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
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
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('dashboard::edit');
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
