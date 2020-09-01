<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');
    }


    public function postLogin(AdminLoginRequest $request)
    {  //validation

        $remember_me = $request->has('remember_me') ? true : false;
        if (auth('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with(['error' => __('admin/login.error')]);
        }
    }


    public function logout()
    {
        $guard = $this->getGuard();
        $guard->logout();

        return redirect()->route('admin.login');
    }


    private function getGuard()
    {
        return auth('admin');
    }
}
