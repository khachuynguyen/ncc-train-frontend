<?php

namespace App\Supports;

use App\Http\Requests\AddProduct;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class StoreImage
{

    public static function storeImage(UploadedFile $image)
    {
        $avatar = $image;
        $ex = $avatar->getClientOriginalExtension();
        $randomName = Str::random(6);
        $fileName = $randomName . date("Y-m-d-h-m-s") . '.' . $ex;
        $linkImage = config('custom')['link_image'] . $fileName;
        $avatar->storeAs(config('custom')['folder_image'], $fileName);
        return $linkImage;
    }

}
