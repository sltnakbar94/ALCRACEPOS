<?php

namespace Modules\Wahana\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Wahana\Entities\WahanaDevices;
use Modules\Wahana\Entities\WahanaCounter;

use Modules\Wahana\Http\Requests\CounterFormRequest;
use Modules\Wahana\Http\Requests\CounterFilterRequest;
use Modules\Wahana\Http\Requests\CounterEditRequest;

use DataTables;
use DB;
use Auth;

class CounterController extends Controller
{
    
    public function json(CounterFilterRequest $request){
        if ($request) {
            $wahana = WahanaCounter::query();
            $wahana->where(['device_id' => $request->id]);
            
            $retrieveJson = DataTables::eloquent($wahana);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($wahana){
                return view('wahana::content/wahana/counter/action/button',[
                    'wahana' => $wahana,
                ]);
            });
            
            $retrieveJson->filter(function ($query)use ($request) {
            },true);

            return $retrieveJson->toJson();
        }else{

        }
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(CounterFilterRequest $request)
    {
        if($request){
            $dataTableURL = route('counterJson',$request->all());
        }else{
            $dataTableURL = route('counterJson');
        }
        $devices = WahanaDevices::where(['id' => $request->id])->first();
        return view('wahana::content/wahana/counter/view',compact([
            'devices','dataTableURL'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(CounterFilterRequest $request)
    {
        $devices = WahanaDevices::where(['id' => $request->id])->first();
        return view('wahana::content/wahana/counter/create',compact([
            'devices'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CounterFormRequest $request)
    {
        $wahana = new WahanaCounter;
        $wahana->device_id = $request->device_id;
        $wahana->counter_number = $request->counter_number;
        $wahana->name = $request->name;
        $wahana->save();

        flash('Berhasil Disimpan')->success();
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('wahana::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(CounterEditRequest $request)
    {
        $devices = WahanaDevices::where(['id' => $request->device])->first();
        $counter = WahanaCounter::where(['id' => $request->id])->first();
        return view('wahana::content/wahana/counter/edit',compact(
            'counter','devices'
        ));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $wahana = WahanaCounter::find($request->id);
        $wahana->counter_number = $request->counter_number;
        $wahana->name = $request->name;
        $wahana->save();

        flash('Berhasil Diperbaharui')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $wahana = WahanaCounter::find($request->id);
        $wahana->delete();

        flash('Berhasil Dihapus')->success();
        return redirect()->back();
    }
}
