<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Products;

class ProductsRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Products::orderByDesc('id')->paginate(6);
    }

    public function getById($id)
    {
        return Products::find($id);
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

    public function getProductByCategory($cateId)
    {
        return Products::where('cate_id', $cateId)->paginate(6);
    }

    public function getProductByCateManu($cateId, $manuId)
    {
        return Products::where('cate_id', $cateId)->where('manu_id', $manuId)->paginate(6);
    }

    public function getProductByManuId($manuId)
    {
        return Products::where('manu_id', $manuId)->paginate(6);
    }

    public function getManuByCate($cateId)
    {
        return Products::select('manu_id')->where('cate_id', $cateId)->groupby('manu_id')->get();
    }

    public function getRelativeProduct($cateid, $productId)
    {
        return Products::where('cate_id', $cateid)->where('id', '!=', $productId)->get()->take(3);
    }

    public function searchProduct($request)
    {
        $query = Products::query();
        if($request->manufacturers)
            $query->where('manu_id', '=', $request->manufacturers );
        if($request->categories)
            $query->where('cate_id', '=', $request->categories );
        return $query->where('product_name', 'like', '%' . $request->find . '%')->orWhere('id', 'like', '%' . $request->find . '%')->paginate(6);

        // return Products::where('product_name', 'like', '%' . $searchs . '%')->orWhere('id', 'like', '%' . $searchs . '%')->paginate(6);
    }

}
