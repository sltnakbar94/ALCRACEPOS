<?php

namespace Modules\CounterRace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\CounterRace\Entities\WahanaHit;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('counterrace::index');
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
        $hit = WahanaHit::firstOrNew(['counter_id' => $request->counter_id,'id' => $request->id]);
        $hit->id = $request->id;
        $hit->counter_id = $request->counter_id;
        $hit->created_at = $request->created_at;
        $hit->updated_at = $request->updated_at;
        $hit->save();
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
