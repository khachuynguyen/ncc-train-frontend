<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoriesRepository;

class CategoriesService
{

    protected CategoriesRepository $categoriesRepository;

    public function __construct(CategoryRepositoryInterface $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getAllCate()
    {
        return $this->categoriesRepository->getAll();
    }

    public function getManuByCateID($id)
    {
        return $this->categoriesRepository->getById($id);
    }

}
