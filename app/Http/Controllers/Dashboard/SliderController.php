<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\SliderImageRequest;
use App\Models\Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductImageRequest;



class SliderController extends Controller
{


    public function addImage()
    {
         $images = Slider::get(['photo']);
        return view('dashboard.sliders.images.create', compact('images'));

    }// end of add Image



    //save images in folder only
    public function saveSliderImage(Request $request)
    {

        $file = $request->file('dzfile');

        $fileName = uploadImage('sliders', $file);

        return response()->json([

            'name' => $fileName,
            'original_name' => $file->getClientOriginalName()

        ]);

    }//end of save product image



    public function saveSliderImageDb(SliderImageRequest $request)
    {
        try {

            if ($request->has('document') && count($request->document) > 0) {

                foreach ($request->document as $image) {

                    Slider::create([

                        'photo' => $image

                    ]);

                }//end of foreach

            }//end of if condition

            return redirect()->back()->with(['success', 'تمت الحفظ بنجاح']);

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error', 'حدث خطأ ما']);
        }

    }//end of saveSliderImageDb

}//end of controller
