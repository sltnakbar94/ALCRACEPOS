<?php

namespace Modules\CounterRace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Carbon\Carbon;
use Log;

use Modules\CounterRace\Entities\WahanaDevices;
use Modules\CounterRace\Entities\WahanaCounter;
use Modules\CounterRace\Entities\WahanaHit;

class CounterRaceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wahana = WahanaDevices::where(['device_type' => 'With Timer','status' => 'ready'])->orderBy('name','asc')
                    ->with(['counter'])
                    ->get();
        return view('counterrace::content/counter/view',compact([
            'wahana'
        ]));
    }

    public function start(Request $request){
        $wahana = WahanaCounter::with('device')->find($request->id);
        // where(['id' => $request->id,'device_type' => 'With Timer'])->first();
        $time = date('Y-m-d H:i:s');
        $wahana->start_at = $time;
        $wahana->end_at = date('Y-m-d H:i:s',strtotime($time.' + '.$wahana->device->timer_count.' minutes'));
        $wahana->save();

        $hit = new WahanaHit;
        $hit->counter_id = $wahana->id;
        $hit->save();
        
        return redirect()->back();
    }

     public function reset(Request $request){
        $wahana = WahanaCounter::where(['id' => $request->id])->first();
        $time = date('Y-m-d H:i:s');
        $wahana->start_at = null;
        $wahana->end_at = null;
        $wahana->save();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('counterrace::create');
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
        return view('counterrace::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('counterrace::edit');
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
