<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DB;
use Auth;

use Modules\Employee\Entities\User;
use Modules\Employee\Entities\UserAdditional;
use Modules\Employee\Entities\Role;

class APIController extends Controller
{
    public function role(){
        $role = Role::get();
        $response = [
            'results' => $role
        ];
        return response()->json($response, 200);
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $employee = User::withTrashed()->with(['additional','role'])
                    ->select('users.*')
                    ->get();
        $response = [
            'results' => $employee
        ];
        return response()->json($response, 200);
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('employee::create');
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
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('employee::edit');
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
