<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProduct;
use App\Http\Requests\EditProduct;
use App\Services\ProductsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    protected ProductsService $productService;

    public function __construct(ProductsService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products, Response::HTTP_OK);
    }

    public function storeProduct(AddProduct $request)
    {
        try {
            $productStored = $this->productService->storeProduct($request);
            if(!$productStored)
                throw new Exception("Error storing product",Response::HTTP_INTERNAL_SERVER_ERROR);
            return response()->json($productStored, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getById($id)
    {
        try {
            $product = $this->productService->getById($id);
            if(!$product)
                throw new Exception("Product not found",Response::HTTP_NOT_FOUND);
            return response()->json($product, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getCode(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $this->productService->deleteProductById($id);
            DB::commit();
            return response()->json("Delete successfully", Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json("Error on delete", $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProduct(EditProduct $request)
    {
        try {
            $product = $this->productService->storeProduct($request);
            if(!$product)
                throw new Exception("Error updating product", Response::HTTP_INTERNAL_SERVER_ERROR);
            return response()->json($product, 200);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(),$exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getManuByCateId($cateId)
    {
        try {
            $manufacturers = $this->productService->getManuByCateId($cateId);
            return response()->json($manufacturers, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode());
        }
    }

    public function getProductByCateId($cateId)
    {
        try {
            $products = $this->productService->getProductByCate($cateId);
            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getProductByCateManu($cateid, $manuid)
    {
        try {
            $products = $this->productService->getProductByCateManu($cateid, $manuid);
            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getProductByManuId($manuId)
    {
        try {
            $products = $this->productService->getProductByManu($manuId);
            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $products = $this->productService->searchProduct($request);
            return response()->json($products, Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception->getMessage(), $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
