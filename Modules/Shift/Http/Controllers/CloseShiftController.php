<?php

namespace Modules\Shift\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Shift\Http\Requests\CloseRequest;
use Auth;
use DB;

use Modules\Shift\Entities\TransItem\Transaction as Item;
use Modules\Shift\Entities\TransTicket\Transaction as Ticket;
use Modules\Shift\Entities\WorkShift;

class CloseShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $item = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')    
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashitem__transaction.shift_id' => ShiftID()]);
                                $query->where(['cashitem__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashitem__cart.subtotal');

        $ticket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashticket__transaction.shift_id' => ShiftID()]);
                                $query->where(['cashticket__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashticket__cart.subtotal');
        return view('shift::content/close/view',compact([
            'item','ticket'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('shift::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CloseRequest $request)
    {
        $item = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')    
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashitem__transaction.shift_id' => ShiftID()]);
                                $query->where(['cashitem__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashitem__cart.subtotal');

        $ticket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashticket__transaction.shift_id' => ShiftID()]);
                                $query->where(['cashticket__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashticket__cart.subtotal');

        $shift = WorkShift::find(ShiftID());
        $shift->close_at = date('Y-m-d H:i:s');
        $shift->total_transaction = $ticket+$item;
        $expected = $shift->beginning_cash+$ticket+$item;
        $shift->expected_cash = $expected;
        $diff = $request->actual_cash - $expected;
        $shift->actual_cash = $request->actual_cash;
        $shift->difference = $diff;
        $shift->notes = $request->notes;
        $shift->save();
        
        return redirect('dashboard');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('shift::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('shift::edit');
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
