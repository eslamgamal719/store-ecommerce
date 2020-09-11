<?php

namespace App\Traits;


use App\Models\Category;

trait categories
{

    public function successMsg($type, $message)
    {
        return redirect()->route('admin.categories', $type)->with(['success' => $message]);
    }


    public function errorMsg($type, $message)
    {
        return redirect()->route('admin.categories', $type)->with(['error' => $message]);
    }


    public function notFoundMsg($message)
    {
        return redirect()->back()->with(['error' => $message]);
    }



    public function getCategoryById($id)
    {
        return Category::orderBy('id', 'DESC')->find($id);
    }

}
