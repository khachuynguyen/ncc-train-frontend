<?php

namespace App\Supports;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DeleteImage
{

    public static function delete(string $linkImage)
    {
        try {
            //directory include image file need to delete
            $folder = config('custom')['folder_image'];
            //tách chuỗi thành mảng string ngăn cách bởi dấu /
            $tmp = explode('/', $linkImage);
            //lấy tên file là phần tử cuối cùng
            $fileName = $tmp[count($tmp) - 1];
            if (Storage::exists($folder . $fileName))
                return Storage::delete($folder . $fileName);
        } catch (\Throwable $th) {
            throw new \Exception("Error on delete image", Response::HTTP_BAD_GATEWAY);
        }
    }

}
