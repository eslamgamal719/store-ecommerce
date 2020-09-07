<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
{
        public function editShippingMethod($type) {

            if($type == "free")
               $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

            elseif($type == "inner")
                $shippingMethod = Setting::where('key', 'local_label')->first();

            elseif($type == "outer")
                $shippingMethod = Setting::where('key', 'outer_label')->first();

            else
                $shippingMethod = Setting::where('key', 'free_shipping_label')->first();

            return view('dashboard.settings.shippings.edit', compact('shippingMethod'));
        }


        public function updateShippingMethod(ShippingRequest $request, $id) {
            try {
                $shipping_method = Setting::find($id);

                DB::beginTransaction();
                $shipping_method->update(['plain_value' => $request->plain_value]);
                $shipping_method->value = $request->value;
                $shipping_method->save();
                DB::commit();

             return redirect()->back()->with(['success'  => __('admin/edit.edit success')]);

            }catch (\Exception $ex) {
                return redirect()->back()->with(['error' =>  __('admin/edit.edit error')]);
                DB::rollback();
            }
        }
}
