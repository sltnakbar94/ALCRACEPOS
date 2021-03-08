<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use DB;
use Auth;

use Modules\Employee\Http\Requests\EmployeeFormRequest;

use App\User;
use Modules\Employee\Entities\UserAdditional;
use Modules\Employee\Entities\Role;

class EmployeeController extends Controller
{
    public function json(Request $request){
        if ($request) {
            $employee = User::query();
            $employee->with(['additional','role'])->select('users.*');
            $retrieveJson = DataTables::eloquent($employee);
            $retrieveJson->addIndexColumn();
            $retrieveJson->addColumn('role',function($employee){
                return $employee->roles()->first()->toArray();
            });
            $retrieveJson->addColumn('action',function($employee){
                return view('employee::content/employee/action/button',[
                    'employee' => $employee,
                ]);
            });
            $retrieveJson->filter(function ($query)use ($request) {
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
        if($request){
            $dataTableURL = route('employeeJson',$request->all());
        }else{
            $dataTableURL = route('employeeJson');
        }
        return view('employee::content/employee/view',compact([
            'dataTableURL'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $role = Role::orderBy('id','asc')->get();
        return view('employee::content/employee/create',compact([
            'role'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(EmployeeFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $getLastInsert = User::where(DB::Raw('DATE(created_at)'),date('Y-m-d'))->count() + 1;
            $code = '11'.$getLastInsert.date('dmy');

            $employee = new User;
            $employee->code = $code;
            $employee->name = $request->name;
            $employee->email = $request->username;
            $employee->password = bcrypt($request->pin);
            $employee->save();

            $additional = new UserAdditional;
            
            $additional->user_id = $employee->id;
            $additional->phone = $request->phone;
            $additional->address = $request->address;
            $additional->save();
            $employee->attachRole($request->level);
            DB::commit();

            flash('Berhasil Disimpan')->success();
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            flash('Oops Something wrong'.$e)->error();
            return redirect()->back();
        }
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
    public function edit(Request $request)
    {
        $employee = User::find($request->id);
        $role = $employee->roles()->get()->first();
        $additional = UserAdditional::where(['user_id' => $employee->id])->first();
        $roles = Role::orderBy('id','asc')->get();

        if (Auth::user()->hasRole('storemanager')) {
            if($employee->hasRole('superadministrator')){
                return redirect()->route('employeeView');    
            }else{
                return view('employee::content/employee/edit',compact([
                    'employee','additional','role','roles'
                ]));
            }
        }
        if (Auth::user()->hasRole('superadministrator')) {
            return view('employee::content/employee/edit',compact([
                'employee','additional','role','roles'
            ]));
        }
        
        
        

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $employee = User::find($request->id);
            $oldRole = $employee->roles()->get()->first();

            $employee->name = $request->name;
            $employee->email = $request->username;
            if ($request->pin == true) {
                $employee->password = bcrypt($request->pin);
            }
            
            
            // $employee->syncRoles([$oldRole->id,$request->level]);
            
            // Remove Old Role
            $employee->detachRole($oldRole->id);
            // Add New Role
            $employee->attachRole($request->level);
            
            $additional = UserAdditional::where(['user_id' => $employee->id])->first();
            $additional->phone = $request->phone;
            $additional->address = $request->address;

             if (Auth::user()->hasRole('storemanager')) {
                if($employee->hasRole('superadministrator')){
                    return redirect()->route('employeeView');    
                }else{
                    $employee->save();
                    $additional->save();
                }
            }
             if (Auth::user()->hasRole('superadministrator')) {
                $employee->save();
                $additional->save();
            }
            

            DB::commit();

            flash('Berhasil Diperbaharui')->success();
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            flash('Oops Something wrong'.$e)->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $employee = User::find($request->id);
        $employee->delete();
        flash('Berhasil Dihapus')->success();
        return redirect()->back();
    }
}
