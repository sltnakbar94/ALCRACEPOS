<?php

namespace Modules\TransactionItem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Auth;
use Carbon\Carbon;

use Modules\TransactionItem\Entities\Transaction;
use Modules\TransactionItem\Entities\TransactionCart;
use Modules\TransactionItem\Entities\TransactionRefund;
use Modules\TransactionItem\Entities\TransactionItem;
use App\User;

use Modules\TransactionItem\Http\Requests\FilterRequest;
use Modules\TransactionItem\Http\Requests\FilterReportRequest;

class TransactionItemController extends Controller
{
    public function json(FilterReportRequest $request){
        if ($request){
            $transaction = Transaction::when(Auth::user()->hasRole('staff'),function($query){
                $query->where(['user_id' => Auth::user()->id]);
                $query->where(DB::Raw('DATE(created_at)'),date('Y-m-d'));
            })
            ->when($request->filled(['staff']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->where(['cashitem__transaction.user_id' => $request->staff]);             
                });
            })
            ->when($request->only(['from','to']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->whereBetween(DB::Raw('DATE(created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                });
            })  
            ->with(['cartSum','refundedSum','itemSum','user']);
            $retrieveJson = DataTables::eloquent($transaction)
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                });
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($transaction){
                return view('transactionitem::content/transaction/action/button',[
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
        $transaction = Transaction::when(Auth::user()->hasRole('staff'),function($query){
                                        $query->where(DB::Raw('DATE(created_at)'),date('Y-m-d'));
                                    })
                                    ->where(['transaction_number' => $request->number])
                                    ->with(['cart' => function($cart){
                                        $cart->with(['item']);
                                    }])
                                    ->with(['refund' => function($cart){
                                        $cart->with(['item']);
                                    }])
                                    ->first();
        $totalTransaction = TransactionCart::where(['transaction_id' => $transaction->id])->sum('subtotal');
        $totalRefund = TransactionRefund::where(['transaction_id' => $transaction->id])->sum('subtotal');

        return view('transactionitem::content/transaction/show',compact([
            'transaction','totalTransaction','totalRefund'
        ]));
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilterReportRequest $request)
    {
        if ($request) {
            $dataTableURL = route('transItemJson',$request->only(['from','to','staff']));
        }else{
            $dataTableURL = route('transItemJson');
        }
        
        /* 7 Days Ago */
        if (Auth::user()->hasRole(['storemanager'])) {
            $date = Carbon::now();
            if ($request->from < $date->subDays(7)->toDateString()) {
                flash('Maksimal 7 Hari yang lalu atau pada Tanggal '.$date->subDays(7)->toDateString())->error();
                return redirect()->back();
            }
        }
        
        $total = Transaction::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashitem__transaction.user_id' => $request->staff]);             
                                });
                            })
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashitem__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            })    
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashitem__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashitem__cart.subtotal');

        $totalItem = Transaction::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashitem__transaction.user_id' => $request->staff]);             
                                });
                            })
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashitem__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            })     
                            ->when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashitem__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->sum('cashitem__cart.quantity');

        $totalTrans = Transaction::when(Auth::user()->hasRole('staff'),function($query){
                                $query->where(['cashitem__transaction.user_id' => Auth::user()->id]);
                                $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            })
                            ->when($request->filled(['staff']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->where(['cashitem__transaction.user_id' => $request->staff]);             
                                });
                            })   
                            ->when($request->only(['from','to']),function($query) use($request){
                                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                                    $insideQuery->whereBetween(DB::Raw('DATE(cashitem__transaction.created_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                                });
                            }) 
                            ->count();
        
        $staff = User::whereRoleIs('staff')->orderBy('name','asc')->get();
        
        return view('transactionitem::content/transaction/view',compact([
            'dataTableURL','total','totalItem','totalTrans','staff'
        ]));
    }


    public function transShowItem(){
        $item = TransactionItem::with(['cart' => function(){

        }])->groupBy('code')->get();
        return response()->json($item, 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transactionitem::create');
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
        return view('transactionitem::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('transactionitem::edit');
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
