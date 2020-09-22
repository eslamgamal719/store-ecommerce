<?php

namespace App\Traits;


use App\Models\Category;

trait categories
{

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


  public function getElementById($id)
    {
        return Category::find($id);
    }


}
