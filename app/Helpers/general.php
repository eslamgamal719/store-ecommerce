<?php



define('PAGINATION_COUNT', 10);

function getFolder() {
    return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
}


function uploadImage($folder, $image) {
    $image->store('/', $folder);
    $fileName = $image->hashName();
    return $fileName;
}



