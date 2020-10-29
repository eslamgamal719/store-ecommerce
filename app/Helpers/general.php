<?php


use App\Models\Category;

define('PAGINATION_COUNT', 10);

    function getFolder()
    {
        return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
    }


    function uploadImage($folder, $image)
    {
        $image->store('/', $folder);
        $fileName = $image->hashName();
        return $fileName;
    }


    function subCatRecursion($categories, $counter, $char)
    {
        foreach ($categories as $category) {
            $space = "";
            $style = "";
            $temp = $counter;
            while ($temp > 0) {
                $space .= "&nbsp&nbsp&nbsp";
                $style .= $char;
                $temp--;
            }

            if (isset($category->id)) {
                echo '<option value="' . $category->id . ' ">' . $space . $style . $category->name . '</option>';
            }

            if (isset($category->_child)) {
                subCatRecursion($category->_child, $counter + 1, $char);
            }

        }
    }


     function getPhoto( $val) {
        return  asset('assets/images/$folder/' . $val);
    }


    function isActive($request) {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);
    }



     function success($route, $message) {
        return redirect()->route($route)->with(['success'=> $message]);
    }


     function error($route, $message) {
        return redirect()->route($route)->with(['error'=> $message]);
    }


     function notFoundMsg($route ,$message)
    {
        return redirect()->route($route)->with(['error' => $message]);
    }


     function getElementById($id)
    {
        return Category::find($id);
    }





