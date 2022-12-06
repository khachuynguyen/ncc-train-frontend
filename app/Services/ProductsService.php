<?php

namespace App\Services;

use App\Http\Requests\AddProduct;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ManufacturerRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SlideRepositoryInterface;
use App\Models\Products;
use App\Models\Slides;
use App\Repositories\CategoriesRepository;
use App\Repositories\ManufacturersRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\SlidesRepository;
use App\Supports\DeleteImage;
use App\Supports\StoreImage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Exception;

class ProductsService
{

    protected ProductsRepository $productRepository;

    protected SlidesRepository $slideRepository;

    protected ManufacturersRepository $manufacturersRepository;

    protected CategoriesRepository $categoriesRepository;

    public function __construct(ProductRepositoryInterface $productRepository, SlideRepositoryInterface $slideRepository, ManufacturerRepositoryInterface $manufacturersRepository, CategoryRepositoryInterface $categoriesRepository)
    {
        $this->productRepository = $productRepository;
        $this->slideRepository = $slideRepository;
        $this->manufacturersRepository = $manufacturersRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function updateProduct(array $productData, int $product_id)
    {
        try {
            $product = $this->productRepository->getById($product_id);
            foreach ($productData as $key => $value) {
                if ($key == 'product_id') {
                    continue;
                }
                if ($key == 'image') {
                    DeleteImage::delete($product->avatar);
                    $linkImage = StoreImage::storeImage($value);
                    $product->avatar = $linkImage;
                    continue;
                }
                // '1','2','3','4' is order of slide
                if ($key == '1' || $key == '2' || $key == '3' || $key == '4') {
                    $current_image = $this->slideRepository->getByOrder($product->id, $key);
                    $countLen = Str::length(($current_image[0]->image));
                    if ($countLen != 0)
                        DeleteImage::delete(($current_image[0]->image));
                    $this->slideRepository->deleteByOrder($product->id, $key);
                    $slide = new Slides();
                    $slide->product_id = $product->id;
                    if (is_uploaded_file($value)) {
                        $linkImage = StoreImage::storeImage($value);
                        $slide->image = $linkImage;
                    } else {
                        $slide->image = null;
                    }
                    $slide->order = $key;
                    $slide->save();
                    continue;
                }
                $product->$key = $value;
            }
            return $product;
        } catch (\Throwable $th) {
            return null;
        }
    }

    private function store(array $productFields)
    {
        try {
            $product = new Products();
            foreach ($productFields as $key => $value) {
                if ($key == 'image') {
                    $linkImage = StoreImage::storeImage($value);
                    $product->avatar = $linkImage;
                    continue;
                }
                $product->$key = $value;
            }
            return $product;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function storeProduct(AddProduct $request)
    {
        if ($request->hasAny('product_id')) {
            $productId = (int) $request->product_id;
            if (!$this->productRepository->getById($productId))
                throw new Exception("Not found", Response::HTTP_NOT_FOUND);
            $productData = $request->except('_method');
            $product = $this->updateProduct($productData, $productId);
            $product->save();
        } else {
            $productData = $request->all();
            $product = $this->store($productData);
            $product->save();
            for ($slideOrder = 1; $slideOrder <= 4; $slideOrder++) {
                $slide = new Slides();
                $slide->product_id = $product->id;
                $slide->order = $slideOrder;
                $slide->save();
            }
        }
        return $product;
    }

    public function deleteProductById($id)
    {
        $product = $this->productRepository->getById($id);
        if (!$product)
            throw new Exception("Not found", Response::HTTP_NOT_FOUND);
        $slides = $product->slides;
        try {
            DeleteImage::delete($product->avatar);
            $this->productRepository->delete($id);
            foreach ($slides as $slide) {
                if (!$slide->image)
                    continue;
                DeleteImage::delete($slide->image);
            }
            $this->slideRepository->delete($id);
        } catch (Exception $exception) {
            throw new Exception("Error on delete", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getById($id)
    {
        $product = $this->productRepository->getById($id);
        if (!$product)
            throw new Exception("Not found", Response::HTTP_NOT_FOUND);
        else {
            $manufacturerName = $this->manufacturersRepository->getById($product->manu_id)->manu_name;
            $categoryName = $this->categoriesRepository->getById($product->cate_id)->cate_name;
            $slides = $product->slides;
            return [
                'product' => $product,
                'suggest' => $this->productRepository->getRelativeProduct($product->cate_id, $product->id),
                'manu_name' => $manufacturerName,
                'cate_name' => $categoryName,
                'slide' => $slides,
            ];
        }
    }

    public function getProductByCate($cateId)
    {
        if (!$this->categoriesRepository->getById($cateId))
            throw new Exception("Not found category", Response::HTTP_NOT_FOUND);
        return $this->productRepository->getProductByCategory($cateId);
    }

    public function getProductByCateManu($cateId, $manuId)
    {
        if (!$this->categoriesRepository->getById($cateId) || !$this->manufacturersRepository->getById($manuId))
            throw new Exception("Not found category or manufacturer", Response::HTTP_NOT_FOUND);
        return $this->productRepository->getProductByCateManu($cateId, $manuId);
    }

    public function getProductByManu($manuId)
    {
        if (!$this->manufacturersRepository->getById($manuId))
            throw new Exception("Not found manufacture", Response::HTTP_NOT_FOUND);
        return $this->productRepository->getProductByManuId($manuId);
    }

    public function getManuByCateId($cateId)
    {
        if (!$this->categoriesRepository->getById($cateId))
            throw new Exception("Not found category", Response::HTTP_NOT_FOUND);
        $manufacturers = $this->productRepository->getManuByCate($cateId);
        try {
            $arr = array();
            foreach ($manufacturers as $manufacturer) {
                array_push($arr, $this->manufacturersRepository->getById($manufacturer->manu_id));
            }
            return $arr;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function searchProduct($request)
    {
        return $this->productRepository->searchProduct($request);
    }

}
