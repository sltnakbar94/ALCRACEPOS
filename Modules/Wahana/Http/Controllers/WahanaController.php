<?php

namespace Modules\Wahana\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Wahana\Http\Requests\WahanaFormRequest;
use Modules\Wahana\Http\Requests\FilteringRequest;

use Modules\Wahana\Entities\WahanaDevices;

use DataTables;
use DB;
use Auth;



class WahanaController extends Controller
{

    public function json(FilteringRequest $request){
        if ($request) {
            $wahana = WahanaDevices::query(); 
            $wahana->when($request->only('type'),function($query) use($request){
                if ($request->has('type')) {
                    $query->where(['device_type' => $request->type]);
                }
            });
            $retrieveJson = DataTables::eloquent($wahana);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('action',function($wahana){
                return view('wahana::content/wahana/action/button',[
                    'wahana' => $wahana,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
            },true);
            return $retrieveJson->toJson();
        }else{
            return redirect()->route('wahanaView');
        }
    }
    
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilteringRequest $request)
    {
        if($request){
            $dataTableURL = route('wahanaJson',$request->all());
        }else{
            $dataTableURL = route('wahanaJson');
        }
        return view('wahana::content/wahana/view',compact(['dataTableURL']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('wahana::content/wahana/create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(WahanaFormRequest $request)
    {
        $wahana = new WahanaDevices; 
        $wahana->name = $request->name;
        $wahana->rates = $request->price;
        $wahana->device_type = $request->type;
        if ($request->type == 'With Timer') {
            $wahana->timer_count = $request->timer_count;
        }
        $wahana->status = 'Ready';
        $wahana->save();

        $setCode = WahanaDevices::find($wahana->id);
        $setCode->code = '110'.$wahana->id;
        $setCode->save();
        
        
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
    public function edit(Request $request)
    {
        $wahana = WahanaDevices::find($request->id);
        if ($wahana == false) {
            return redirect()->route('wahanaView');
        }

        return view('wahana::content/wahana/edit',compact([
            'wahana'
        ]));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(WahanaFormRequest $request)
    {
        $wahana = WahanaDevices::find($request->id);
        // query
        $wahana->name = $request->name;
        if (Auth::user()->hasRole('superadministrator')) {
            $wahana->rates = $request->price;
        }
        $wahana->device_type = $request->type;
        if ($request->type == 'With Timer') {
            $wahana->timer_count = $request->timer_count;
        }
        $wahana->status = 'Ready';
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
        $wahana = WahanaDevices::find($request->id);
        if ($wahana == false) {
            return redirect()->route('wahanaView');
        }
        $wahana->delete();
        
        flash('Berhasil Dihapus')->success();
        return redirect()->back();
    }
}
