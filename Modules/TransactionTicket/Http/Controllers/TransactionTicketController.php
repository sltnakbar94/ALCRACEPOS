<?php

namespace Modules\TransactionTicket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Auth;
use Carbon\Carbon;

use Modules\TransactionTicket\Entities\Transaction;
use Modules\TransactionTicket\Entities\TransactionCart;
use Modules\TransactionTicket\Entities\TransactionRefund;
use Modules\TransactionTicket\Entities\TransactionItem;
use App\User;

use Modules\TransactionTicket\Http\Requests\FilterRequest;
use Modules\TransactionTicket\Http\Requests\FilterReportRequest;

class TransactionTicketController extends Controller
{
    public function json(FilterReportRequest $request){
        if ($request) {
            $transaction = Transaction::with(['user'])->when(Auth::user()->hasRole('staff'),function($query){
                $query->where(['user_id' => Auth::user()->id]);
                $query->where(DB::Raw('DATE(created_at)'),date('Y-m-d'));
            })
            ->when($request->filled(['staff']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->where(['user_id' => $request->staff]);             
                });
            })
            ->when($request->only(['from','to']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->whereBetween(DB::Raw('DATE(created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                });
            })  
            ->with(['cartSum','refundedSum']);
            // return response()->json(Auth::user(), 200);
            $retrieveJson = DataTables::eloquent($transaction)
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                });
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('type',function($transaction){
                if ($transaction->ticket_type == 'pass') {
                    return 'Tiket Terusan';
                }else{
                    return 'Tiket Biasa';
                }
            });
            $retrieveJson->addColumn('action',function($transaction){
                return view('transactionticket::content/transaction/action/button',[
                    'transaction' => $transaction,
                ]);
            });
            $retrieveJson->addColumn('subtotal',function($transaction){
                if ($transaction->cartSum) {
                    return number_format($transaction->cartSum->aggregate);
                }else{
                    return 'REFUNDED';
                }
            });
            $retrieveJson->addColumn('quantity',function($transaction){
                if ($transaction->itemSum) {
                    return number_format($transaction->itemSum->aggregate);
                }else{
                    return 'REFUNDED';
                }
            });
            $retrieveJson->filter(function($query) use ($request){
            },true);
            return $retrieveJson->toJson();
        }else{

        }
    }
    
    public function transShow(FilterRequest $request){
        $transaction = Transaction::where(['transaction_number' => $request->number])
                                    ->when(Auth::user()->hasRole('staff'),function($query){
                                        $query->where(['user_id' => Auth::user()->id]);
                                        $query->where(DB::Raw('DATE(created_at)'),date('Y-m-d'));
                                    })
                                    ->with(['cart' => function($cart){
                                        $cart->with(['item']);
                                    }])
                                    ->with(['refund' => function($cart){
                                        $cart->with(['item']);
                                    }])
                                    ->first();
        $totalTransaction = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
        $totalRefund = TransactionRefund::where(['transaction_id' => $transaction->id])->sum('subtotal');

        $beforeCashback = TransactionCart::where(['transaction_id' => $transaction->id])->sum(DB::raw('quantity * price'));
        return view('transactionticket::content/transaction/show',compact([
            'transaction','totalTransaction','beforeCashback','totalRefund'
        ]));
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilterReportRequest $request)
    {
        if ($request) {
            $dataTableURL = route('transTicketJson',$request->all());
        }else{
            $dataTableURL = route('transTicketJson');
        }

        /* 7 Days Ago */
        if (Auth::user()->hasRole(['storemanager'])) {
            $date = Carbon::now();
            if ($request->from < $date->subDays(7)->toDateString()) {
                flash('Maksimal 7 Hari yang lalu atau pada Tanggal '.$date->subDays(7)->toDateString())->error();
                return redirect()->back();
            }
        }
        
        $total = Transaction::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashticket__transaction.user_id' => $request->staff]);             
                                });
                            })
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashticket__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            })
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashticket__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashticket__cart.subtotal');
        
        $totalItem = Transaction::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashticket__transaction.user_id' => $request->staff]);             
                                });
                            })
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashticket__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            })
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashticket__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashticket__cart.quantity');

        $totalTrans = Transaction::when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashticket__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashticket__transaction.user_id' => $request->staff]);             
                                });
                            })
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashticket__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            })
                            ->count();

        $staff = User::whereRoleIs('staff')->orderBy('name','asc')->get();

        return view('transactionticket::content/transaction/view',compact([
            'dataTableURL','total','totalItem','totalTrans','staff'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transactionticket::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('transactionticket::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('transactionticket::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
