<?php

namespace App\Services;

use App\Interfaces\ManufacturerRepositoryInterface;
use App\Repositories\ManufacturersRepository;

class ManufacturerService
{

    protected ManufacturersRepository $manufacturersRepository;

    public function __construct(ManufacturerRepositoryInterface $manufacturersRepository)
    {
        $this->manufacturersRepository = $manufacturersRepository;
    }

    public function getAllManu()
    {
        return $this->manufacturersRepository->getAll();
    }

}
