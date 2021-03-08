<?php

namespace Modules\Shift\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use PDF;
use Auth;

use Modules\Shift\Entities\TransItem\Transaction as Item;
use Modules\Shift\Entities\TransTicket\Transaction as Ticket;
use Modules\Shift\Entities\WorkShift;
use App\User;

class ReportShiftController extends Controller
{
    public function json(Request $request){
        if ($request) {
            $shift = WorkShift::query();
            $shift->with('user');
            $shift->when($request->filled(['staff']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->where(['shift.user_id' => $request->staff]);             
                });
            });
            $shift->when($request->only(['from','to']),function($query) use($request){
                $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                    $insideQuery->whereBetween(DB::Raw('DATE(open_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                });
            });
            $retrieveJson = DataTables::eloquent($shift);
            $retrieveJson->addIndexColumn()->order(function ($query) {
                $query->orderBy('id', 'desc');
            });
            $retrieveJson->addColumn('beginning_cash',function($shift){
                return number_format($shift->beginning_cash);
            });
            $retrieveJson->addColumn('total_transaction',function($shift){
                return number_format($shift->total_transaction);
            });
            $retrieveJson->addColumn('expected_cash',function($shift){
                return number_format($shift->expected_cash);
            });
            $retrieveJson->addColumn('actual_cash',function($shift){
                return number_format($shift->actual_cash);
            });
            $retrieveJson->addColumn('difference',function($shift){
                return number_format($shift->difference);
            });

            $retrieveJson->addColumn('detail', function($shift){
                return '<a href="'.route('showShift',['id' => $shift->id]).'" class="btn btn-secondary btn-sm">Rincian <i class="fa fa-angle-double-right"></i></a>';
            });
            $retrieveJson->rawColumns(['detail']);
            $retrieveJson->filter(function($query) use ($request){
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
        $shift = WorkShift::with('user')
                ->when($request->filled(['staff']),function($query) use($request){
                    $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                        $insideQuery->where(['shift.user_id' => $request->staff]);             
                    });
                })
                ->when($request->only(['from','to']),function($query) use($request){
                    $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                        $insideQuery->whereBetween(DB::Raw('DATE(open_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                    });
                })
                ->selectRaw('(SUM(total_transaction)) as aggregate_actual_cash')->first();
                
        $deposited = WorkShift::with('user')
                ->when($request->filled(['staff']),function($query) use($request){
                    $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                        $insideQuery->where(['shift.user_id' => $request->staff]);             
                    });
                })
                ->when($request->only(['from','to']),function($query) use($request){
                    $query->when(Auth::user()->hasRole(['storemanager','superadministrator']),function($insideQuery) use($request){
                        $insideQuery->whereBetween(DB::Raw('DATE(open_at)'), [date('Y-m-d',strtotime($request->from)), date('Y-m-d',strtotime($request->to))]);             
                    });
                })
                ->selectRaw('(SUM(actual_cash)) as aggregate_actual_cash')->first();

        $totalTransItem = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')
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
                            
        $totalTransTicket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')
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

        if ($request) {
            $dataTableURL = route('jsonShift',$request->only(['from','to','staff']));
        }else{
            $dataTableURL = route('jsonShift');
        }

        $staff = User::whereRoleIs('staff')->orderBy('name','asc')->get();
        return view('shift::content/report/view',compact([
            'dataTableURL','staff','shift','deposited','totalTransTicket','totalTransItem'
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
    public function store(Request $request)
    {
    }

    public function pdf(Request $request){
        $shift = WorkShift::where('id' , $request->id)->first();   
        $ticketTransaction = Ticket::where([
                'shift_id' => $shift->id,
            ])
            // ->where(DB::Raw('DATE(created_at)'),date('Y-m-d'))
            ->count();

        $itemTransaction = Item::where([
                'shift_id' => $shift->id,
            ])
            // ->where(DB::Raw('DATE(created_at)'),date('Y-m-d'))
            ->count();

        $item = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')    

                            ->where(['cashitem__transaction.shift_id' => $shift->id])
                                // $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            ->sum('cashitem__cart.subtotal');

        $ticket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')

                            ->where(['cashticket__transaction.shift_id' => $shift->id])
                                // $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            ->sum('cashticket__cart.subtotal'); 
        $pdf = PDF::setPaper(['0','0','212.598','20082.6772'], 'portrait')->loadView('shift::content/pdf/receipt',compact([
                    'item','ticket','ticketTransaction','itemTransaction','shift'
                ]));
                return $pdf->stream();
    }
    
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        $shift = WorkShift::where('id' , $request->id)->first();   
        $ticketTransaction = Ticket::where([
                'shift_id' => $shift->id,
            ])
            // ->where(DB::Raw('DATE(created_at)'),date('Y-m-d'))
            ->count();

        $itemTransaction = Item::where([
                'shift_id' => $shift->id,
            ])
            // ->where(DB::Raw('DATE(created_at)'),date('Y-m-d'))
            ->count();

        $item = Item::join('cashitem__cart','cashitem__cart.transaction_id','=','cashitem__transaction.id')    

                            ->where(['cashitem__transaction.shift_id' => $shift->id])
                                // $query->where(DB::Raw('DATE(cashitem__transaction.created_at)'),date('Y-m-d'));
                            ->sum('cashitem__cart.subtotal');

        $ticket = Ticket::join('cashticket__cart','cashticket__cart.transaction_id','=','cashticket__transaction.id')

                            ->where(['cashticket__transaction.shift_id' => $shift->id])
                                // $query->where(DB::Raw('DATE(cashticket__transaction.created_at)'),date('Y-m-d'));
                            ->sum('cashticket__cart.subtotal');    
            
        if (!$shift) {
            return redirect()->back();
        }
        return view('shift::content/close/view',compact([
            'shift','ticketTransaction','itemTransaction','item','ticket'
        ]));
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
