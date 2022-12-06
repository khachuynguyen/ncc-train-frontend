<?php

namespace App\Repositories;

use App\Interfaces\SlideRepositoryInterface;
use App\Models\Slides;

class SlidesRepository implements SlideRepositoryInterface
{

    public function getAll()
    {
        return Slides::all();
    }

    public function getById($product_id)
    {
        return Slides::where('product_id', $product_id)->get();
    }

    public function getByOrder($product_id, $order)
    {
        return Slides::where('product_id', $product_id)->where('order', $order)->get();
    }

    public function deleteByOrder($product_id, $order)
    {
        return Slides::where('product_id', $product_id)->where('order', $order)->delete();
    }

    public function delete($product_id)
    {
        return Slides::where('product_id', $product_id)->delete();
    }

}
