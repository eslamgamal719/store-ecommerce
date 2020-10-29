<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminLoginRequest;


class LoginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');

    }//end of login


    public function postLogin(AdminLoginRequest $request)
    {  //validation

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {

            return redirect()->route('admin.dashboard');

        } else {

            return redirect()->back()->with(['error' => __('admin/login.error')]);

        }

    } //end of post login



    public function logout()
    {
        $guard = $this->getGuard();

        $guard->logout();

        return redirect()->route('admin.login');

    } //end of logout



    private function getGuard()
    {
        return auth('admin');

    }//end of get guard


}//end of controller
