<?php

namespace App\Supports;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;

class CheckValidateImage
{

    public static function checkImage(UploadedFile $file)
    {
        $extentions = $file->getClientOriginalExtension();
        $imageExtensions = ['jpg', 'jpeg', 'png', 'jpe'];
        if (in_array($extentions, $imageExtensions) && ((float)filesize($file)) / 1024 < 50000) {
            return true;
        } else {
            return false;
        }
    }
}
