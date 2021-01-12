<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminsController extends Controller
{

    public function index() {
        $admins = Admin::latest()->where('id', '<>', auth()->id())->paginate(10);
        return view('dashboard.admins.index', compact('admins'));
    }


    public function create() {
        $roles = Role::get();
        return view('dashboard.admins.create', compact('roles'));
    }


    public function store(AdminRequest $request) {
            $data = $request->except('password', 'password_confirmation');
            $data['password'] = bcrypt($request->password);

            Admin::create($data);
            return success('admin.admins.index', 'admin/admins.added_successfully');


    }
}
