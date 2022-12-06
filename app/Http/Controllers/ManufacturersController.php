<?php

namespace App\Http\Controllers;

use App\Interfaces\ManufacturerRepositoryInterface;
use App\Repositories\ManufacturerRepository;
use App\Services\ManufacturerService;
use Illuminate\Http\Request;

class ManufacturersController extends Controller
{

    protected ManufacturerService $manufacturerService;

    public function __construct(ManufacturerService $manufacturerService) {
        $this->manufacturerService = $manufacturerService;
    }

    public function index()
    {
        $data = $this->manufacturerService->getAllManu();
        return response()->json($data, 200);
    }

}
