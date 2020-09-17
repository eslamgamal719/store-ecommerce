<?php

namespace App\Traits;


use App\Models\Category;

trait generalMsg
{
########################## categories Msg #####################################
    public function successMsg($type, $message)
    {
        return redirect()->route('admin.categories', $type)->with(['success' => $message]);
    }


    public function errorMsg($type, $message)
    {
        return redirect()->route('admin.categories', $type)->with(['error' => $message]);
    }
########################## categories Msg #####################################



    ###################public messages ###############################
    public function success($route, $message) {
        return redirect()->route($route)->with(['success'=> $message]);
    }


    public function error($route, $message) {
        return redirect()->route($route)->with(['error'=> $message]);
    }

    public function notFoundMsg($route ,$message)
    {
        return redirect()->route($route)->with(['error' => $message]);
    }

    ###################public messages ###############################

  public function getElementById($id)
    {
        return Category::find($id);
    }


}
