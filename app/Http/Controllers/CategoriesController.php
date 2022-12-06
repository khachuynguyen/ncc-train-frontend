<?php

namespace App\Http\Controllers;

use App\Services\CategoriesService;

class CategoriesController extends Controller
{

    protected CategoriesService $cateService;

    public function __construct(CategoriesService $cateService) {
        $this->cateService = $cateService;
    }

    public function index()
    {
        $data = $this->cateService->getAllCate();
        return response()->json($data, 200);
    }

    public function getManuByCateId($id)
    {
        $data = $this->cateService->getManuByCateID($id);
        return $data;
    }

}
