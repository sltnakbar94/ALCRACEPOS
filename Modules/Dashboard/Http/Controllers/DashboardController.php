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

use StatisticController as Statistic;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if (!empty($request->month)) {
            $legends = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $lastMonth = 12 - date('m');
            $legendSelected = array_slice($legends,0,date('Y', strtotime($request->month)));
            $series[0]['name'] = 'Pendapatan Tiket Wahana';
            // $series[1]['name'] = 'Pendapatan Corner';

            foreach($legendSelected as $key => $item){
                $i = $key + 1;
                $series[0]['data'][] = (int)Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                            ->whereMonth('cashticket__cart.created_at' ,$i)
                            ->whereYear('cashticket__cart.created_at' , '=',date('Y', strtotime($request->month)))
                            ->sum('cashticket__cart.subtotal');

                // $series[1]['data'][] = (int)Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                //                 ->whereMonth('cashitem__transaction.created_at',$i)
                //                 ->whereYear('cashitem__transaction.created_at',date('Y'))
                //                 ->sum('cashitem__cart.subtotal');
            }
        }

        $dayTicket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                        ->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'))
                        ->sum('cashticket__cart.subtotal');

        $monthTicket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                        ->whereMonth('cashticket__cart.created_at' ,date('m'))
                        ->whereYear('cashticket__cart.created_at' ,date('Y'))
                        ->sum('cashticket__cart.subtotal');

        $yearTicket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                        ->whereYear('cashticket__cart.created_at' ,date('Y'))
                        ->sum('cashticket__cart.subtotal');

        $dayItem = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                            ->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'))
                            ->sum('cashitem__cart.subtotal');

        $monthItem = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                            ->whereMonth('cashitem__transaction.created_at',date('m'))
                            ->whereYear('cashitem__transaction.created_at',date('Y'))
                            ->sum('cashitem__cart.subtotal');

        $yearItem = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                            ->whereYear('cashitem__transaction.created_at',date('Y'))
                            ->sum('cashitem__cart.subtotal');

        if (!empty($request->month)) {
            $statisticYear = ['legend' => $legendSelected, 'series' => $series];
            $daysInMonth = Carbon::createFromFormat('Y-m', $request->month)->daysInMonth;
        }else{
            $statisticYear = StatisticController::getYears();
            // $daysInMonth = cal_days_in_month(CAL_GREGORIAN,7,2019);
            $daysInMonth = request('month') == false ? Carbon::now()->daysInMonth : Carbon::createFromFormat('m',request('month'))->daysInMonth;
        }


        /* Ticket Report Monthly */
        $reportTicket = [];
        $sum_subtotal = 0;
        $sum_quantity = 0;
        for ($i=0; $i < $daysInMonth ; $i++) {
            $key = $i + 1;
            $subtotal = TicketCart::where(DB::raw('DAY(created_at)'),$key)
            ->whereMonth('created_at',request('month') ?? date('m'))
            ->whereYear('created_at',date('Y'))->sum('subtotal');

            $quantity = TicketCart::where(DB::raw('DAY(created_at)'),$key)
            ->whereMonth('created_at',request('month') ?? date('m'))
            ->whereYear('created_at',date('Y'))->sum('quantity');

            $reportTicket[] = [
                'date' => $key,
                'quantity' => number_format($quantity),
                'value' => number_format($subtotal),
            ];
            $sum_subtotal += $subtotal;
            $sum_quantity += $quantity;
        }
        // return response()->json($res, 200);
        $LOL_month = date('m', strtotime($request->month));

        if (!empty($request->month)) {
            return view('dashboard::content/dashboard/view',compact([
                'dayTicket','monthTicket','yearTicket',
                'dayItem','monthItem','yearItem','statisticYear','reportTicket','sum_subtotal','sum_quantity', 'LOL_month'
            ]));
        }else{
            return view('dashboard::content/dashboard/view',compact([
                'dayTicket','monthTicket','yearTicket',
                'dayItem','monthItem','yearItem','statisticYear','reportTicket','sum_subtotal','sum_quantity'
            ]));
        }
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

    public function getYear(Request $request)
    {
        dd($request);
    }
}
