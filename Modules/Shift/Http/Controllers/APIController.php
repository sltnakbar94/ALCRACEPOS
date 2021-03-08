<?php

namespace Modules\Shift\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Shift\Entities\WorkShift;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('shift::index');
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
        $shift = WorkShift::firstOrNew(['id' => $request->id]);
        $shift->user_id = $request->user_id;
        $shift->open_at = $request->open_at;
        $shift->close_at = $request->close_at;
        $shift->beginning_cash = $request->beginning_cash;
        $shift->total_transaction = $request->total_transaction;
        $shift->actual_cash = $request->actual_cash;
        $shift->difference = $request->difference;
        $shift->expected_cash = $request->expected_cash;
        $shift->refund = $request->refund;
        $shift->notes = $request->notes;
        $shift->save();
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
