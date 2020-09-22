<?php


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





