<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {

            DB::beginTransaction();
            $role = Role::create($request->except(['_token', 'permissions']));
            $role->permissions = json_encode($request->permissions);
            $role->save();
            DB::commit();

            return success('admin.roles.index',  __('admin/roles.added_successfully'));
        } catch (\Exception $ex) {

            DB::rollback();
            return success('admin.roles.index',  __('admin/roles.error'));
        }


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('dashboard.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        try {

            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update($request->except('_token', 'permissions'));
            $role->permissions = json_encode($request->permissions);
            $role->save();

            DB::commit();

            return success('admin.roles.index',  __('admin/roles.updated_successfully'));

        } catch (\Exception $ex) {
            DB::rollback();
            return success('admin.roles.index',  __('admin/roles.error'));
        }

    }


}
