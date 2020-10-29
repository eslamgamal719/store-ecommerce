<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShippingRequest;


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

        }//end of edit shipping



        public function updateShippingMethod(ShippingRequest $request, $id) {
            try {

                $shipping_method = Setting::find($id);

                $shipping_method->update($request->all());

             return redirect()->back()->with(['success'  => __('admin/settings.edit success')]);

            }catch (\Exception $ex) {

                return redirect()->back()->with(['error' =>  __('admin/settings.edit error')]);
            }

        }//end of update shipping


}//end of controller
