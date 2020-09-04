<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $admin = Admin::find(auth('admin')->user()->id);
        return view('dashboard.profile.edit', compact('admin'));
    }


    public function updateProfile(ProfileRequest $request)
    {
        try {
            $data = $request->all();
            $admin = Admin::find((auth('admin')->user()->id));
            $oldPassword = $admin->password;

            if (empty($data['password'])) {
                unset($data['password']);
                $admin->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
                return redirect()->back()->with(['success' => __('admin/edit.edit success')]);
            } else {
                $newPassword = $data['password'];
                if (Hash::check($request->oldpassword, $oldPassword)) {
                    $admin->password = Hash::make($newPassword);
                    $admin->update([
                        'name' => $request->name,
                        'email' => $request->email
                    ]);
                    $admin->save();
                    return redirect()->back()->with(['success' => __('admin/edit.edit success')]);
                } else {
                    return redirect()->back()->with(['error' => __('admin/edit.old password not match')]);
                }
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => __('admin/edit.edit error')]);
        }
    }
}
