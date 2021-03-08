<?php

namespace Modules\ChangePassword\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use Auth;
use Modules\ChangePassword\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('changepassword::content/changepass/view');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('changepassword::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(ChangePasswordRequest $request)
    {
        
        $user = User::find(Auth::user()->id);
        /* If Passwor Null */
        if ($user->password == null) {
            $user->password = bcrypt($request->newPassword);
            $user->save();
            flash('Pin Berhasil Di ganti')->success();
            return redirect()->back();
        }else{
            /* If Password Existing */
            if (Auth::guard('web')->attempt(['email' => Auth::user()->email, 'password' => $request->password])) {
                $user->password = bcrypt($request->newPassword);
                $user->save();
                flash('Pin Berhasil Di ganti')->success();
                return redirect()->back();
            }else{
                flash('Pin Lama Salah')->error();
                return redirect()->back();
            }
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('changepassword::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('changepassword::edit');
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
